<?php

namespace App\Traits;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait SystemUpgrade
{
    function updateSystemPage()
    {
        $data['prowriters_version'] = Setting::get_setting('prowriters_version');
        return view('setup.system_upgrade', compact('data'));
    }

    function updateSystem(Request $request)
    {
        // 1. Order status upgrade - done
        // 2. AddArchiveColumnToUsersTable migrate and make all value for column invoiced to 1
        $prowriters_version = Setting::get_setting('prowriters_version');
        if ($prowriters_version == get_software_version()) {
            return redirect()->back()->withSuccess('Your system is already up to date');
        }
        if (!defined('STDIN')) define('STDIN', fopen("php://stdin", "r"));

        $success = false;
        try {
            \Artisan::call("migrate --force");            
            $this->save_records(['prowriters_version' => get_software_version()]);
            $success = true;
        } catch (\Exception  $e) {
            $success = false;
        }
        if ($success) {
            return redirect()->back()->withSuccess('Upgraded your system to v.' . get_software_version());
        } else {
            return redirect()->back()->withFail('Could not upgrade the system');
        }
    }

   
    
}
