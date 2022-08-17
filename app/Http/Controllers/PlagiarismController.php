<?php

namespace App\Http\Controllers;

use App\Enums\CartType;
use App\Http\Requests\PlagiarismRequest;
use App\Services\CartService;
use App\Services\PaymentOptionsService;
use App\Services\PlagiarismService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\View\View;
use Psy\Exception\ErrorException;

class PlagiarismController extends Controller
{
    protected $service;

    public function __construct(PlagiarismService $service)
    {
        $this->middleware(['check_subscription:1'])->only('index');
        $this->service = $service;
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
            $request->validated();
            $data = [
                "_token" => $request->_token,
                "text" => $request->text,
                "language" => $request->language,
                "scrapeSources" => (boolean)$request->scrapeSources,
                "includeCitations" => (boolean)$request->includeCitations,
            ];
             $response = $this->service->detectPlagiarism($data); // integrate with multiple APIs plagiarism detection
            if (!$response ){
                return back()->withErrors('This service is not available in your location');
            }else
            $this->service->insertLog($userId, 1); // trigger event to new insert in log of plagiarism
            return view('plagiarism.result', compact('response'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
