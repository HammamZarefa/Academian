<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('setup.coupon.index', compact('coupons'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {

        return view('setup.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            'code' => "required|string|distinct|min:3|unique:coupons",
            "amount" => "required",
            "type" => "required"
        ])->validate();

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->amount = $request->amount;
        $coupon->type = $request->type;
        $coupon->start_at = $request->start_at;
        $coupon->expired_at = $request->expired_at;
        $request->status ? $coupon->status = 'enable' : $coupon->status = 'disable';
        if ($coupon->save()) {
            return redirect()->route('coupons')->with('success', 'Data added successfully');
        } else {
            return redirect()->route('coupons')->with('error', 'Data failed to add');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostCategory $postCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($coupons)
    {
        $coupon = Coupon::findOrFail($coupons);
        $coupon->destroy($coupons);

        return redirect()->route('coupons')->with('success', 'Data deleted successfully');
    }


    public function checkValidity(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        if ($coupon)
            if ($this->is_expired($coupon))
                return response()->json(['expired' => 'This coupon is expired']);
            else if ($this->is_disable($coupon))
                return response()->json(['Disabled' => 'This coupon is Disabled']);
            else {
                if ($this->reedem($coupon))
                    return response()->json(['coupon' => $coupon], 200);
                else  return response()->json(['Failed' => 'Cannot use this coupon']);
            }

        else
            return response()->json(['Failed' => 'Not Found']);
    }

    public function is_expired($coupon)
    {
        if (isset($coupon['start_at']) && $coupon['start_at'] < Now())
            return true;

        if (isset($coupon['expired_at']) && $coupon['expired_at'] < NOW())
            return true;

        return false;
    }

    public function is_disable($coupon)
    {
        return $coupon['status'] == "enable" ? false : true;
    }


    public function status($id)
    {
        $coupon = Coupon::findorfail($id);
        $coupon->status == 'enable' ? $coupon->status = 'disable' : $coupon->status = 'enable';
        $coupon->save();
        return redirect()->route('coupons')->with('success', 'Status Updated successfully');
    }

    public function reedem($coupon)
    {
        $cart = Session::get('cart', []);
        $order = Order::findorfail($cart['order_id']);
        if(!is_null($order->coupon))
            return false;
        $coupon->type == 'fixed' ? $total = $cart['cart_total'] - $coupon->amount :
            $total = $cart['cart_total'] - ($cart['cart_total'] * $coupon->amount / 100);
        $cart['cart_total'] = $total;
        $order->total = $total;
        $order->coupon = $coupon->code;
        $order->save();
        Session::put('cart', $cart);
        return true;
    }
}
