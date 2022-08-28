<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function checkValidity(Request $request)
    {

        $coupon =Coupon::where('code', $request->code)->first();
        if(!$this->is_expired($coupon) && !$this->is_enable($coupon))
            return 'not valid';
        else
            return $coupon->amount;
    }

    public function is_expired($coupon)
    {
        return true;
//        if($coupon['start_at'] < Now() or $coupon['expaired_at'] < NOW())
//            return false;
//        else return true;
    }

    public function is_enable($coupon)
    {
       return $coupon->status =="enable" ? true : false;
    }
}
