<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\Http\Requests\PlagiarismRequest;
use App\Services\CartService;
use App\Services\PaymentOptionsService;
use App\Services\PlagiarismService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PlagiarismController extends Controller
{
    public $plagiarism;
    protected $service;
    private $cart;


    public function __construct(PlagiarismService $service,CartService $cart)
    {
        // $this->middleware(['auth']);
         $this->middleware(['check_subscription:1'])->only('index');
        $this->service = $service;
        $this->cart = $cart;

    }

    /**
     * Display an interface to detected plagiarism.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('plagiarism.index');
    }

    /**
     * detected plagiarism.
     *
     * @return Application|Factory|View
     */
    public function detect(PlagiarismRequest $request)
    {
        try {
            $userId = auth()->user()->id;
            $data = $request->validated();
            $response=$this->service->detectPlagiarism( $data ); // integrate with multiple APIs plagiarism detection
            $this->service->trigEvent( $userId ); // trigger event to new insert in log of plagiarism
            return view('plagiarism.result', compact('response'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
            // abort(404);
        }
    }
    protected function subscripeShow(PaymentOptionsService $paymentOptions){
        $data['total'] = 1000;
        $data['payment_options'] = $paymentOptions->all();
        $data['show_wallet_option'] = true;

        if ($this->cart->getCartType() != CartType::NewOrder) {
            $data['show_wallet_option'] = false;
        } else {
            if (isset($this->cart->getCart()['order_number'])) {
                $order = $this->cart->getCart();
                $data['order_number'] = $order['order_number'];
                $data['order_link'] = route('orders_show', $order['order_id']);
            }
        }





        if($data['total']==0)
            return  redirect()->route('homepage')->withSuccess('We Well Catch You Soon');
        return view('subscripe.select_payment_method')->with('data', $data);
//        return view('subscripe.select_payment_method');
    }

//    public function plagiarism(){
//
//
//        return view( 'plagiarism.setting.index' );
//    }
}
