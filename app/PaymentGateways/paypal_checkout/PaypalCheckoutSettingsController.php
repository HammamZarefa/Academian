<?php

namespace App\PaymentGateways\paypal_express;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class PaypalCheckoutSettingsController extends Controller
{

    private $uniqueName = 'paypal_checkout';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
        $validator = Validator::make($request->all(), [
            'environment' => 'required',
            'name' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',         
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }        

        $keys = [
            'environment' => $request->environment,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,            
        ];
        
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
