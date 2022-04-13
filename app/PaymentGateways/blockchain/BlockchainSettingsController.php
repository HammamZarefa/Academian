<?php

namespace App\PaymentGateways\blockchain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PaymentGatewaySettingsService;

class BlockchainSettingsController extends Controller
{
    private $uniqueName = 'blockchain';

    public function updateSettings(Request $request, PaymentGatewaySettingsService $settingService)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'api_key' => 'required',
            'xpub_code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(['gateway' => $this->uniqueName]);
        }

        $keys = [
            'api_key' => $request->api_key,
            'xpub_code' => $request->xpub_code,
//            'environment' => $request->environment,
        ];
        $settingService->save($this->uniqueName, $request->name, $keys, $request->inactive);

        return redirect()->back()->withSuccess('Successfully updated');
    }
}