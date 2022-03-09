<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\SubmittedWork;
use App\Service;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Events\TaskSelfAssignedEvent;
use App\Events\TaskAssignedEvent;
use App\Events\StartedWorkingEvent;
use App\Events\WorkSubmittedEvent;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::task_dropdown();
        $data['statistics'] = Order::statistics(auth()->user()->id);

        return view('task.index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $orders = Order::where('staff_id', auth()->user()->id)->with([
            'customer'
        ])->orderBy('id', 'DESC');

        return Datatables::eloquent($orders)->addColumn('task_html', function ($order) {

            return view('task.partials.task_list_row', compact('order'))->render();
        })
            ->rawColumns([
                'task_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->order_number) {

                    $query->where('number', $request->order_number);
                }

                if ($request->order_status_id) {

                    $query->where('order_status_id', $request->order_status_id);
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

    public function browse_work(Request $request)
    {
        $data['services_list'] = [
            '' => 'All'
        ] + Service::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();

        return view('task.browse_work', compact('data'));
    }

    public function datatable_browse_work(Request $request)
    {
        $orders = Order::with([
            'customer'
        ])->where('order_status_id', ORDER_STATUS_NEW)
            ->whereNull('staff_id')->orderBy('id', 'DESC');

        return Datatables::eloquent($orders)->addColumn('task_html', function ($order) {

            return view('task.partials.task_list_row', compact('order'))->render();
        })
            ->rawColumns([
                'task_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->service_id) {
                    $query->where('service_id', $request->service_id);
                }
            })
            ->make(true);
    }

    public function self_assign_task(Request $request, Order $order)
    {
        if (empty($order->staff_id)) {

            $order->staff_id = auth()->user()->id;
            $order->save();

            // Dispatching Event
            event(new TaskSelfAssignedEvent($order, auth()->user()));

            return redirect()->route('orders_show', $order->id)->withSuccess('The task has been assigned to you');
        } elseif ($order->staff_id == auth()->user()->id) {

            return redirect()->route('orders_show', $order->id);
        } else {

            return redirect()->route('browse_work')->withFail('Sorry, the task is already assigned to someone else');
        }
    }

    public function assign_task(Request $request, Order $order)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'staff_payment_amount' => 'required|gt:0|regex:/^\d+(\.\d{1,2})?$/'
        ], [
            'staff_payment_amount.required' => 'Payment amount is required',
            'staff_payment_amount.regex' => 'Not a valid amount',
            'staff_payment_amount.gt' => 'Should be greater than 0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        $order->staff_id = $request->staff_id;
        $order->staff_payment_amount = $request->staff_payment_amount;
        $order->save();

        $changes = $order->getChanges();

        if (isset($changes['staff_id']) && $order->staff_id) {
            // Dispatching Event
            event(new TaskAssignedEvent(auth()->user(), $order));
        }

        if (isset($changes['staff_payment_amount']) && $order->staff_payment_amount) {

            // Log user's activity
            $subject = anchor($order->number, route('orders_show', $order->id));
            logActivity($order, 'updated payout amount for ' . $subject);
        }


        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function submit_work(Request $request, Order $order)
    {
        if (auth()->user()->id != $order->staff_id) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'name' => 'required',
            'display_name' => 'required'
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withFail($validator->errors()
                ->all()[0]);
        }

        $order->order_status_id = ORDER_STATUS_SUBMITTED_FOR_APPROVAL;
        $order->save();

        $request['user_id'] = auth()->user()->id;
        $request['order_id'] = $order->id;

        $submittedWork = SubmittedWork::create($request->all());

        // Dispatching Event
        event(new WorkSubmittedEvent($submittedWork));

        return redirect()->back()->withSuccess('Thank you. Your work has been submitted to client for approval');
    }

    public function start_working(Request $request, Order $order)
    {
        if (auth()->user()->id != $order->staff_id) {
            abort(404);
        }

        $order->order_status_id = ORDER_STATUS_IN_PROGRESS;
        $order->save();

        // Dispatching Event
        event(new StartedWorkingEvent($order));

        return redirect()->back();
    }
}
