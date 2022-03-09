<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\PushNotification;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {       

        return view('my_account.notifications');
    }

    public function paginate(Request $request)
    {  

        return Datatables::of(auth()->user()->notifications)
        ->addColumn('description', function ($notification) {
               return anchor_link($notification->data['message'], route('notification_redirect_url', $notification->id ) );
        })
        ->addColumn('status', function ($notification) {
               return ($notification->read_at) ? 'Read' : 'Unread';
        })
        ->editColumn('created_at', function ($notification) {
               return $notification->created_at->diffForHumans();
        })

            ->rawColumns([
            'description'
        ])

        ->make(true);
    }


    function get_unread_notifications()
    {
        $notifications = auth()->user()->unreadNotifications()
        ->orderBy('created_at', 'DESC')->take(15)->get();
        $records = [];
        if(count($notifications) > 0)
        {
            foreach ($notifications as $notification) 
            {
                
                $data               = $notification->data;
                $data['moment']     = $notification->created_at->diffForHumans();
                $data['url']        = route('notification_redirect_url', $notification->id ) ;
                $records[]          = $data;
            }
        }

        $pushNotfiication = auth()->user()->pushNotification()->get();

        if($pushNotfiication->count() > 0)
        {
            $pushNotfiication->first()->delete();
        }

        return response()->json($records);
    }



    function redirect_url($id)
    {
        if($id)
        {
            $notification   = auth()->user()->notifications->where('id', $id);

            if(count($notification) > 0)
            {
                $notification   = $notification->first();
                $url            = $notification->data['url'];         
                $notification->markAsRead();

                return redirect()->to($url);
            }
            
        }
        abort(404);
    }

    function mark_all_notification_as_read()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }


    public function push_notification()
    {        
        $notfiication = auth()->user()->pushNotification()->get();

        if($notfiication->count() > 0)
        {
            return $notfiication->first()->number;
        }

        return 0;
    }
}
