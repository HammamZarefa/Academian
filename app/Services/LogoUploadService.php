<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Setting;

class LogoUploadService
{

    function upload(Request $request)
    {
        try {

            $old_company_logo = Setting::get_setting('company_logo');

            $file = $this->StoreBase64ToFile($request->input('file'));

            Setting::save_settings([
                'company_logo' => $file
            ]);

            if (Storage::disk('public')->exists($old_company_logo)) {

                Storage::disk('public')->delete($old_company_logo);
            }

            return [
                'status' => 1,
                'file_url' => asset(Storage::url($file))
            ];
        } catch (\Exception $e) {
            return [
                'status' => 2,
                'msg' => "Upload was not successful. Please try again."
            ];
        }
    }

    public function StoreBase64ToFile($base64Data)
    {
        $image = base64_decode($base64Data);
        $filename = uniqid() . '_' . time() . '.png';
        $path = 'uploads/' . $filename;
        Storage::disk('public')->put($path, $image, 'public');

        return $path;
    }
}