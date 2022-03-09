<?php

namespace App\PaymentGateways\two_checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class TwoCheckoutSettingsController extends Controller
{
    private $uniqueName = 'two_checkout';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',           
            'merchant_code' => 'required',
            'secret_key' => 'required',      
            'publishable_key' => 'required', 
            'private_key'=> 'required',      
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        $keys = [
            'merchant_code' => $request->merchant_code,
            'publishable_key' => $request->publishable_key,
            'secret_key' => $request->secret_key,   
            'private_key' => $request->private_key,      
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
