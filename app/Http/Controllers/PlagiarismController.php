<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\Http\Requests\PlagiarismRequest;
use App\Services\CartService;
use App\Services\PaymentOptionsService;
use App\Services\PlagiarismService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PlagiarismController extends Controller
{
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
            $this->service->insertLog( $userId,1 ); // trigger event to new insert in log of plagiarism
            return view('plagiarism.result', compact('response'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
