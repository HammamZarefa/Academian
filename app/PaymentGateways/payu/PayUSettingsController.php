<?php

namespace App\PaymentGateways\payu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class PayUSettingsController extends Controller
{
    private $uniqueName = 'payu';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
    
        $validator = Validator::make($request->all(), [
            'environment' => 'required',
            'name' => 'required',           
            'merchant_key' => 'required',
            'merchant_salt' => 'required',      
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        $keys = [
            'merchant_key' => $request->merchant_key,
            'merchant_salt' => $request->merchant_salt,  
            'environment' => $request->environment,    
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
