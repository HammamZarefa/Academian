<?php

namespace App\Http\Controllers;

use App\Order;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Events\NewCommentEvent;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;
use App\Events\DeliveryAcceptedEvent;
use App\Events\OrderStatusChangedEvent;
use Yajra\DataTables\Facades\DataTables;
use App\Events\RequestedForRevisionEvent;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = Order::admin_dropdown();
        $data['statistics'] = Order::statistics();

        $data['staff_list'] = [
                '' => 'All',
                'unassigned' => 'Unassigned'
            ] + $data['staff_list'];

        $data['order_status_list'] = [
                '' => 'All'
            ] + $data['order_status_list'];
        $data['dead_line_list'] = [
            '' => 'N/A',
            'today' => 'Today',
            'tommorrow' => 'Tommorrow',
            'day_after_tommorrow' => 'The day after tommorrow'
        ];
        return view('order.index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $orders = Order::with([
            'assignee',
            'customer'
        ]);

        // display by nearest due date
        (empty($request->show_by_nearest_due_date)) ? $orders->orderBy('id', 'DESC') : $orders->orderBy('dead_line', 'DESC');

        // Show archived orders
        (empty($request->show_archived)) ? $orders->whereNull('archived') : $orders->whereNotNull('archived');

        // Show show_pending_payment_orders
        if ($request->show_pending_payment_orders) {
            $orders->where('order_status_id', ORDER_STATUS_PENDING_PAYMENT);
        } else {
            $orders->where('order_status_id', '<>', ORDER_STATUS_PENDING_PAYMENT);
        }

        return Datatables::eloquent($orders)->addColumn('customer_html', function ($order) {

            return view('order.partials.order_list_row', compact('order'))->render();
        })
            ->rawColumns([
                'customer_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->order_number) {
                    $query->where('number', $request->order_number);
                }

                if ($request->order_status_id) {
                    $query->where('order_status_id', $request->order_status_id);
                }

                if ($request->customer_id) {
                    $query->where('customer_id', $request->customer_id);
                }

                if ($request->staff_id) {
                    if ($request->staff_id == 'unassigned') {
                        $query->whereNull('staff_id');
                    } else {
                        $query->where('staff_id', $request->staff_id);
                    }
                }

                if ($request->order_date) {
                    list($from, $to) = explode(' - ', $request->order_date);
                    $query->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
                }

                if ($request->dead_line) {
                    $now = Carbon::now();
                    switch ($request->dead_line) {
                        case 'tommorrow':
                            $now->addDays(1);
                            break;
                        case 'day_after_tommorrow':
                            $now->addDays(2);
                            break;
                        default:
                            break;
                    }
                    $query->whereDate('dead_line', $now->toDateString('Y-m-d'));
                }
            })
            ->make(true);
    }

    function show(Order $order)
    {
        $data = [];

        if (auth()->user()->hasRole('admin')) {
            // Always allow an admin to visit the page
            $data = Order::admin_dropdown();
        } else if (auth()->user()->hasRole('staff')) {
            /*
             * Restrict a staff from accessing the page if:
             * 1. He is not the creator/customer of the order
             * 2. He is not the assignee of the order/task
             * 3. Browsing Work is not enabled
             */
            if (settings('enable_browsing_work') != 'yes') {
                if ($order->customer_id != auth()->user()->id && $order->staff_id != auth()->user()->id) {
                    abort(404);
                }
            }
        } else {
            /*
             * Not an admin or a staff, which means the user is a client
             * Restrict a client from accessing the page if he is not the owner of the order
             *
             */
            if ($order->customer_id != auth()->user()->id) {
                abort(404);
            }
        }

        return view('order.show', compact('order', 'data'));
    }

    public function quote(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('order_page');
        }
        $data = Order::dropdown();
        $data['title'] = 'Get an instant quote';
        return view('order.create', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = Order::dropdown();
        $data['title'] = 'Let\'s get started on your project!';

        return view('order.create', compact('data'));
    }


    function post_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'order_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order = Order::find($request->order_id);

        if (!auth()->user()->hasRole('admin')) {
            if (!in_array(auth()->user()->id, [
                $order->customer_id,
                $order->staff_id
            ])) {
                abort(404);
            }
        }

        if ($message = Purifier::clean($request->input('message'))) {
            $comment = new Comment();
            $comment->body = $message;
            $comment->user_id = auth()->user()->id;
            $order->comments()->save($comment);

            // Dispatching Event
            event(new NewCommentEvent($comment));
        }

        return redirect()->back();
    }

    function accept_delivered_item(Request $request, Order $order)
    {
        // Only the customer can mark it as accepted
        if (auth()->user()->id != $order->customer_id) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'submitted_work_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order->order_status_id = ORDER_STATUS_COMPLETE;
        $order->save();

        // Dispatching Event
        event(new DeliveryAcceptedEvent($order));

        return redirect()->route('orders_rating', $order->id)->withSuccess('Thank you very much. Your order is now marked as complete');
    }

    function revision_request_page(Request $request, Order $order)
    {
        if (!isRevisionAllowed($order)) {
            abort(404);
        }

        if ($order->order_status_id != ORDER_STATUS_SUBMITTED_FOR_APPROVAL) {
            return redirect()->route('orders_show', $order->id);
        }

        if (auth()->user()->id != $order->customer_id) {
            abort(404);
        }

        return view('order.revision_request', compact('order'));
    }

    function revision_request(Request $request, Order $order)
    {
        // Only the customer can mark it as accepted
        if (auth()->user()->id != $order->customer_id) {
            abort(404);
        }

        if ($order->order_status_id != ORDER_STATUS_SUBMITTED_FOR_APPROVAL) {
            return redirect()->route('orders_show', $order->id);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $submitted_work = $order->latest_submitted_work();

        if ($submitted_work->count() > 0) {
            $submitted_work->needs_revision = TRUE;
            $submitted_work->customer_message = Purifier::clean($request->message);
            $submitted_work->save();

            // Update Order Status
            $order->order_status_id = ORDER_STATUS_REQUESTED_FOR_REVISION;
            $order->save();

            // Dispatching Event
            event(new RequestedForRevisionEvent($order));
        }

        return redirect()->route('orders_show', $order->id);
    }

    public function change_status(Request $request, Order $order)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'order_status_id' => 'required'
        ], [

            'order_status_id.required' => 'Order status is required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $previous = $order->status->name;
        $order->order_status_id = $request->order_status_id;
        $order->save();
        $new = $order->status->name;

        // Dispatching Event
        event(new OrderStatusChangedEvent($order, $previous, $new));

        return redirect()->back()->withSuccess('Status updated');
    }

    public function follow(Request $request, Order $order)
    {
        $order->followers()->attach(auth()->user()->id);

        return redirect()->back()->withSuccess('Following');
    }

    public function unfollow(Request $request, Order $order)
    {
        $order->followers()->detach(auth()->user()->id);

        return redirect()->back()->withSuccess('Unfollowed');
    }

    public function archive(Request $request, Order $order)
    {
        $order->archived = now();
        $order->save();

        return redirect()->back()->withSuccess('Archived');
    }

    public function unarchive(Request $request, Order $order)
    {
        $order->archived = null;
        $order->save();

        return redirect()->back()->withSuccess('Unarchived');
    }

    public function destroy(OrderService $orderService, Order $order)
    {
        if ($orderService->destroy($order)) {
            return redirect()->route('orders_list')->withSuccess('Order deleted');
        } else {
            return redirect()->back()->withFail('Sorry, could not delete the order');
        }

    }
}
