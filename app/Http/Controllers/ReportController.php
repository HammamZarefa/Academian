<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use App\Wallet;

class ReportController extends Controller
{

    function income_statement(Request $request)
    {
        $data = NULL;
        if ($request->date) {
            try {

                list($from, $to) = explode(' - ', $request->date);
                $data['from_date'] = $from;
                $data['to_date'] = $to;

                $select = DB::raw("service_id, SUM(IFNULL(total,0)) as amount, SUM(IFNULL(staff_payment_amount, 0)) AS payroll_expense");

                $record = Order::select($select)->with([
                    'service'
                ])
                    ->where('order_status_id', ORDER_STATUS_COMPLETE)
                    ->whereBetween(DB::raw('DATE(created_at)'), [
                        $from,
                        $to
                    ])
                    ->groupBy('service_id')
                    ->get();

                if ($record->count() > 0) {
                    $data['record'] = $record;
                    $data['total_revenue'] = $record->sum('amount');
                    $data['total_expense'] = $record->sum('payroll_expense');
                    $data['income'] = $data['total_revenue'] - $data['total_expense'];
                }
            } catch (\Exception $e) {
            }
        }
        else
        {
            $data['from_date'] = null;
            $data['to_date'] = null;
        }
        return view('report.income_statement', compact('data'));
    }

    function income_graph()
    {
        $data = [];
        for ($i = 4; $i >= 0; $i = $i - 1) {
            $date = now()->subMonths($i);

            $start   = $date->copy()->startofMonth()->toDateTimeString();
            $end     = $date->copy()->endofMonth()->toDateTimeString();

            $profit           = $this->getProfit($start, $end);
            $data['values'][] = $profit;
            $data['labels'][] = $date->format('F');
            $data['formatted_values'][$profit] = format_money($profit);
        }

        return response()->json($data);
    }

    private function getProfit($start, $end)
    {
        return Order::where('order_status_id', ORDER_STATUS_COMPLETE)
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('total - IFNULL(staff_payment_amount, 0)'));
    }


    public function activity_log()
    {
        return view('report.activity_log');
    }

    public function datatable_activity_log(Request $request)
    {
        $activity = Activity::orderBy('created_at', 'DESC');

        return Datatables::eloquent($activity)->addColumn('causer_name', function ($activity) {

            return '<a href="' . route('user_profile', $activity->causer->id) . '">' . $activity->causer->full_name . '</a>';
        })
            ->addColumn('date', function ($activity) {
                return date("d-M-Y H:i", strtotime($activity->created_at));
            })

            ->rawColumns([
                'date',
                'causer_name',
                'description'
            ])

            ->make(true);
    }

    public function destroy_activity()
    {
        Activity::truncate();

        return redirect()->back()->withSuccess('Activities deleted');
    }

    public function totalWalletBlance()
    {
        $data['balance'] = Wallet::sum('balance');     
        return view('report.total_wallet_balance', compact('data'));
    }
}
