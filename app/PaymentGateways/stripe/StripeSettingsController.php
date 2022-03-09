<?php

namespace App\PaymentGateways\stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class StripeSettingsController extends Controller
{
    private $uniqueName = 'stripe';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required',           
            'publishable_key' => 'required',
            'secret_key' => 'required',      
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        $keys = [
            'publishable_key' => $request->publishable_key,
            'secret_key' => $request->secret_key,      
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
