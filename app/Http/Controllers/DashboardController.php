<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\User;
use App\Order;
use App\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'dashboard']);        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['activities'] = Activity::limit(5)->orderBy('created_at', 'DESC')->get();       
     
        return view('dashboard', compact('data'));

    }

    private function usersCount()
    {
        return User::whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(7)->toDateString(), Carbon::today()->toDateString()])
        ->doesntHave('roles')->get()->count();
    }

    private function ordersCount()
    {
        return Order::where('order_status_id', ORDER_STATUS_IN_PROGRESS)->get()->count();
    }

    private function paidBillsAmount()
    {
        $total = Bill::whereBetween('paid', [Carbon::now()->subDays(30)->toDateString(), Carbon::today()->toDateString()])->get()->sum('total');

        return format_money($total);
    }

    private function profitAmount()
    {
        $total = Order::where('order_status_id', ORDER_STATUS_COMPLETE)
        ->whereBetween(DB::raw('DATE(created_at)'), [Carbon::now()->subDays(30)->toDateString(), Carbon::today()->toDateString()])
        ->sum(DB::raw('total - IFNULL(staff_payment_amount, 0)'));

        return format_money($total);
    }


    public function statistics(Request $request)
    {
       switch ($request->name) {
            case 'users_count':              
                    $data = $this->usersCount();
               break;
            case 'orders_count':
                    $data = $this->ordersCount();
               break;
            case 'paid_bills_amount':
                    $data = $this->paidBillsAmount();
               break;
            case 'profit_amount':                  
                    $data = $this->profitAmount();
               break;           
           default:
               $data = 0;
               break;
       }

       return response()->json($data);
    }

}
