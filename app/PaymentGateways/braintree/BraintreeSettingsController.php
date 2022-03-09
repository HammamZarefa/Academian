<?php

namespace App\PaymentGateways\braintree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class BraintreeSettingsController extends Controller
{

    private $uniqueName = 'braintree';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {
        $validator = Validator::make($request->all(), [
            'environment' => 'required',
            'name' => 'required',
            'merchant_id' => 'required',
            'public_key' => 'required',
            'private_key' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        if (!(isset($request->is_paypal_enabled))) {
            $request['is_paypal_enabled'] = 0;
        }

        $keys = [
            'merchant_id' => $request->merchant_id,
            'public_key' => $request->public_key,
            'private_key' => $request->private_key,
            'is_paypal_enabled' => $request->is_paypal_enabled,
            'environment' => $request->environment,
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}
