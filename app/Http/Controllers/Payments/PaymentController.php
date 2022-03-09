<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function datatable(Request $request)
    {
        if ($request->user_id) {
            $payments = Payment::whereHas('from', function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            });
        } else {
            $payments = Payment::with([
                'from'
            ]);
        }
        $payments->orderBy('id', 'DESC');

        return Datatables::eloquent($payments)
            ->addColumn('date', function ($payment) {
                return date("d-M-Y", strtotime($payment->created_at));
            })
            ->editColumn('amount', function ($payment) {
                return format_money($payment->amount);
            })
            ->editColumn('attachment', function ($payment) {
                if ($payment->attachment) {
                    $url = route('download_attachment', ['file' => $payment->attachment]);
                    return   anchor('<i class="fas fa-cloud-download-alt"></i>', $url);
                }
            })
            ->addColumn('from', function ($payment) {

                return '<a href="' . route('user_profile', $payment->user_id) . '">' . $payment->from->full_name . '</a>';
            })
            ->rawColumns([
                'date',
                'amount',
                'from',
                'attachment'

            ])
            ->make(true);
    }

    public function myPaymentsdatatable(Request $request)
    {
        $payments = Payment::whereHas('from', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        })->orderBy('id', 'DESC');


        return Datatables::eloquent($payments)
            ->addColumn('date', function ($payment) {
                return date("d-M-Y", strtotime($payment->created_at));
            })
            ->editColumn('amount', function ($payment) {
                return format_money($payment->amount);
            })
            ->rawColumns([
                'date',
                'amount'

            ])
            ->make(true);
    }
}
