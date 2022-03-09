<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Bill;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Events\BillReceivedEvent;
use App\Events\BillPaidEvent;
use App\Exceptions\NoUnbilledWorkException;
use App\Services\BillService;

class BillController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $data = Bill::admin_dropdown();
        $data['statistics'] = Bill::statistics();

        return view('bill.index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $bills = Bill::with([
            'from'
        ])->orderBy('id', 'DESC');

        return Datatables::eloquent($bills)->editColumn('number', function ($bill) {

            return '<a href="' . route('bills_show', $bill->id) . '">' . $bill->number . '</a>';
        })
            ->addColumn('date', function ($bill) {
            return date("d-M-Y", strtotime($bill->created_at));
        })
            ->editColumn('total', function ($bill) {
            return format_money($bill->total);
        })
            ->addColumn('from', function ($bill) {

            return '<a href="' . route('user_profile', $bill->user_id) . '">' . $bill->from->full_name . '</a>';
        })
            ->addColumn('status', function ($bill) {

            return ($bill->paid) ? 'Paid' : 'Unpaid';
        })
            ->rawColumns([
            'date',
            'total',
            'from',
            'status',
            'number'
        ])
            ->filter(function ($query) use ($request) {

            if ($request->number) {
                $query->where('number', $request->number);
            }
            if ($request->from) {
                $query->where('user_id', $request->from);
            }
            if ($request->status) {
                if ($request->status == 'paid') {
                    $query->whereNotNull('paid');
                } elseif ($request->status == 'unpaid') {
                    $query->whereNull('paid');
                }
            }
        })
            ->make(true);
    }

    public function create(Request $request)
    {
        $unbilled_tasks = auth()->user()
            ->unbilled_tasks()
            ->get();

        $data['total'] = 0;

        if ($unbilled_tasks->count() > 0) {
            $data['total'] = $unbilled_tasks->sum('staff_payment_amount');
        }

        return view('bill.create', compact('unbilled_tasks', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required|max:500',
            'note' => 'required|max:500',
            'staff_invoice_number' => 'sometimes|unique:bills,user_id,' . auth()->user()->id
        ], [
            'staff_invoice_number.unique' => 'The invoice number already exists'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $billService = new BillService();
            $bill = $billService->create($request->except('_token'));

            // Dispatching Event
            event(new BillReceivedEvent($bill));

            return redirect()->route('my_requests_for_payment')->withSuccess('Your payment request has been submitted');
        } catch (NoUnbilledWorkException $e) {
            return redirect()->route('my_requests_for_payment')->with('info', 'Sorry, there is no unbilled work by you');
        } catch (\Exception $e) {}

        return redirect()->back()->withFail('Your payment request was not successful. Please try again');
    }
    

    public function show(Bill $bill)
    {
        return view('bill.show', compact('bill'));
    }

    public function my_requests_for_payment(Request $request)
    {
        $data['uncleared_payment_total'] = auth()->user()->uncleared_payment_total();

        return view('bill.my_requests_for_payment', compact('data'));
    }

    public function datatable_my_requests_for_payment(Request $request)
    {
        $bills = auth()->user()
            ->bills()
            ->orderBy('id', 'DESC');

        return Datatables::eloquent($bills)->addColumn('bill_html', function ($bill) {

            return view('bill.partials.bill_list_row', compact('bill'))->render();
        })
            ->rawColumns([
            'bill_html'
        ])
            ->filter(function ($query) use ($request) {

            if ($request->number) {
                $query->where('staff_invoice_number', $request->number);
            }

            if ($request->status) {
                if ($request->status == 'paid') {
                    $query->whereNotNull('paid');
                } elseif ($request->status == 'unpaid') {
                    $query->whereNull('paid');
                }
            }
        })
            ->make(true);
    }

    function mark_as_paid(Request $request, Bill $bill)
    {
        $bill->paid = Carbon::now()->format("Y-m-d");
        $bill->save();

        // Dispatching Event
        event(new BillPaidEvent($bill));

        // Log user's activity
        $subject = anchor($bill->number, route('bills_show', $bill->id));
        logActivity($bill, 'marked as paid '. $subject);

        return redirect()->back()->withSuccess('Marked as paid');
    }

    function mark_as_unpaid(Request $request, Bill $bill)
    {
        $bill->paid = NULL;
        $bill->save();

        // Log user's activity
        $subject = anchor($bill->number, route('bills_show', $bill->id));
        logActivity($bill, 'marked as unpaid '. $subject);

        return redirect()->back()->withSuccess('Marked as unpaid');
    }
}
