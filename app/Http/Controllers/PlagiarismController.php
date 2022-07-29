<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlagiarismRequest;
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

    public function __construct(PlagiarismService $service)
    {
        // $this->middleware(['auth']);
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
            $userId = 1;
            $data = $request->validated();
            $response=$this->service->detectPlagiarism( $data ); // integrate with multiple APIs plagiarism detection
            $this->service->trigEvent( $userId ); // trigger event to new insert in log of plagiarism
            return view('plagiarism.result', compact('response'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
            // abort(404);
        }
    }
}
