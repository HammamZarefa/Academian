<?php

namespace App\Http\Controllers\Payments;

use App\User;
use App\Service;
use App\Urgency;
use App\WorkLevel;
use App\Enums\PaymentReason;
use Illuminate\Http\Request;
use App\Events\PaymentApprovedEvent;
use App\Events\PaymentDisapprovedEvent;
use App\PendingForApprovalPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PaymentRecordService;
use Yajra\DataTables\Facades\DataTables;

class PendingPaymentsController extends Controller
{
    public function index(Request $request)
    {
        return view('payment.pending_for_approval');
    }

    public function datatable(Request $request)
    {
        $payments = PendingForApprovalPayment::with([
            'from'
        ])->orderBy('id', 'DESC');

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
                    return   anchor('Download', $url);
                }
            })
            ->editColumn('payment_reason', function ($payment) {
                if ($payment->payment_reason == PaymentReason::order) {
                    $url = route('orders_show', $payment->cart->order_id);
                    return  anchor('Order', $url);
                }
                return 'Wallet Top-up';
            })
            ->addColumn('from', function ($payment) {

                return '<a href="' . route('user_profile', $payment->user_id) . '">' . $payment->from->full_name . '</a>';
            })
            ->addColumn('details', function ($payment) {

                return '<a href="' . route('user_profile', $payment->user_id) . '">View Details</a>';
            })
            ->addColumn('action', function ($payment) {

                $a = '<a class="btn btn-sm btn-success approve" href="' . route('pending_payment_approve', $payment->id) . '"><i class="far fa-thumbs-up"></i></a>';
                $a .= ' <a class="btn btn-sm btn-danger disapprove" href="' . route('pending_payment_disapprove', $payment->id) . '"><i class="far fa-thumbs-down"></i></a>';
                return $a;
            })
            ->rawColumns([
                'date',
                'amount',
                'from',
                'attachment',
                'action',
                'payment_reason'
            ])
            ->make(true);
    }

    public function approvePendingPayment(PendingForApprovalPayment $approvedPayment, PaymentRecordService $paymentRecordService)
    {
        DB::beginTransaction();
        $success = false;
        try {

            // Store the payment
            $payment = $paymentRecordService->store($approvedPayment->user_id, $approvedPayment->method, $approvedPayment->amount, $approvedPayment->reference, $approvedPayment->attachment);

            // Trigger event
            event(new PaymentApprovedEvent($payment));

            // If the reason for payment was order, then confirm the order
            if (($approvedPayment->payment_reason == PaymentReason::order) && !empty($approvedPayment->cart)) {
                // Confirm Order          
                $this->getOrderService()->confirmOrderPayment($approvedPayment->cart->order_id);
            }
            // Now delete the record
            $approvedPayment->delete();
            $success = true;
            DB::commit();
        } catch (\Exception  $e) {
            $success = false;
            DB::rollback();
        }

        if ($success) {
            // the transaction worked ...            
            return redirect()->route('pending_payment_approvals')->withSuccess('Payment Approved');
        } else {

            return redirect()->back()->withFail('Sorry the request was not successful, please try again');
        }
    }

    function disapprovePendingPayment(PendingForApprovalPayment $disapprovedPayment)
    {
        // If the reason for payment was order, then the order status
        if (($disapprovedPayment->payment_reason == PaymentReason::order) && !empty($disapprovedPayment->cart)) {
            $this->getOrderService()->markAsPaymentDisapproved($disapprovedPayment->cart->order_id);
        }

        // Now delete the record
        $data = $disapprovedPayment->toArray();
        $disapprovedPayment->delete();
        event(new PaymentDisapprovedEvent($data));

        return redirect()->back()->withSuccess('Payment Disapproved');
    }

    private function getOrderService()
    {
        return app()->make('App\Services\OrderService');
    }
}
