<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\AvatarUploadService;
use App\Tag;
use App\Http\Requests\ChangeProfilePhotoRequest;
use App\Services\UserService;
use App\Services\CartService;
use App\Enums\CartType;
use App\Setting;
use App\Order;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MyAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $user = auth()->user();
        $user->setMetaData();

        if ($request->group == 'edit-profile') {
            $data['tag_id_list'] = Tag::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            $data['timezones'] = Setting::get_list_of_time_zone();
        }

        return view('my_account.index', compact('user', 'data'));
    }

    public function change_password(Request $request)
    {
        $password = auth()->user()->password;

        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($password) {

                    if (!Hash::check($value, $password)) {
                        return $fail(__('Current password is not valid'));
                    }
                }
            ],
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Log user's activity       
        logActivity($user, 'updated password');

        return redirect()->back()->withSuccess('Password updated');
    }

    public function update_profile(Request $request, UserService $userService)
    {
        $rule = [
            'first_name' => 'required',
            'last_name' => 'required',
            'timezone' => 'required',
            'bio' => 'max:500',
            'address' => 'max:500'
        ];

        if (auth()->user()->hasRole('staff')) {
            $rule['preferred_payment_method'] = 'required';
            $rule['payment_method_details'] = 'required';
        }

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userService->update_self_profile($request, auth()->user());

        // Log user's activity       
        logActivity(auth()->user(), 'updated profile');

        return redirect()->back()->withSuccess('Successfully updated');
    }

    public function change_photo(ChangeProfilePhotoRequest $request, AvatarUploadService $avatar)
    {
        // Log user's activity       
        logActivity(auth()->user(), 'updated avatar');
        return response()->json($avatar->upload($request, auth()->user()));
    }

    public function orders()
    {
        $data = Order::customer_dropdown();

        $data['order_count'] = auth()->user()->my_orders()->count();

        $data['order_status_list'] = [
            '' => 'All'
        ] + $data['order_status_list'];

        $data['dead_line_list'] = [
            '' => 'N/A',
            'today' => 'Today',
            'tommorrow' => 'Tommorrow',
            'day_after_tommorrow' => 'The day after tommorrow'
        ];
        return view('my_account.orders', compact('data'));
    }

    public function my_orders_datatable(Request $request)
    {
        $orders = Order::with(['assignee'])->where('customer_id', auth()->user()->id);

        if (empty($request->show_by_nearest_due_date)) {
            $orders->orderBy('id', 'DESC');
        } else {
            $orders->orderBy('dead_line', 'DESC');
        }

        return Datatables::eloquent($orders)->addColumn('customer_html', function ($order) {

            return view('my_account.partials.order_list_row', compact('order'))->render();
        })
            ->rawColumns([
                'customer_html'
            ])
            ->filter(function ($query) use ($request) {

                if ($request->order_number) {
                    $query->where('number', $request->order_number);
                }

                if ($request->order_status_id) {
                    $query->where('order_status_id', $request->order_status_id);
                }


                if ($request->order_date) {
                    list($from, $to) = explode(' - ', $request->order_date);
                    $query->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
                }

                if ($request->dead_line) {
                    $now = Carbon::now();
                    switch ($request->dead_line) {
                        case 'tommorrow':
                            $now->addDays(1);
                            break;
                        case 'day_after_tommorrow':
                            $now->addDays(2);
                            break;
                        default:
                            break;
                    }
                    $query->whereDate('dead_line', $now->toDateString('Y-m-d'));
                }
            })
            ->make(true);
    }

    public function walletTopup(Request $request, CartService $cart)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = ['cart_total' => $request->amount];
        $cart->setCart($data, CartType::WalletTopUp);

        return redirect()->route('choose_payment_method');
    }
}
