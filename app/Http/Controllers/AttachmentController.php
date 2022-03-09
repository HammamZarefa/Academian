<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{

    function upload(Request $request)
    {
        $attachment = Storage::putFile('attachments', $request->file('file'));

        return response()->json([
            'name' => $attachment,
            'display_name' => $request->file->getClientOriginalName()
        ], 200);
    }

    function remove(Request $request)
    {
        if (Storage::exists($request->name)) {
            Storage::delete($request->name);
        }
    }

    function download(Request $request)
    {
        try {

            return Storage::download($request->file);
        } catch (\Exception $e) {
            //
            abort(404);
        }
    }
}
