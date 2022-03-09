<?php

namespace App\PaymentGateways\paystack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class PaystackSettingsController extends Controller
{
    private $uniqueName = 'paystack';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',           
            'public_key' => 'required',
            'secret_key' => 'required',      
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        $keys = [
            'public_key' => $request->public_key,
            'secret_key' => $request->secret_key,      
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
