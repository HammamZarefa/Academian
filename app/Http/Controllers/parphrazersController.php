<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParaphraseRequest;
use App\Services\ParaphraseService;
use App\Services\SummarizeService;
use Illuminate\Support\Str;
use League\Flysystem\Config;

class parphrazersController extends Controller
{
    protected $service;

    public function __construct(ParaphraseService $service)
    {
        $this->middleware(['check_subscription:3'])->only('index');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paraphraser.index');
    }

    public function detect(ParaphraseRequest $request)
    {
        try {
            $userId = auth()->user()->id;
            $data = $request->validated();
            $response = $this->service->paraphrase($data); // integrate with multiple APIs paraphrase
            if (!$response ){
                return back()->withErrors('This service is not available in your location');
            }else
            session()->flashInput($request->input());
            $string = Str::of($response['rewrite'])->explode(' ');
            $countRequest = Str::of($request->text)->explode(' ')->count();
            $count = $string->count();
            $this->service->insertLog($userId, 1); // trigger event to new insert in log of Paraphrase
            return view('paraphraser.index', compact('response', 'count', 'countRequest'))
                ->withInput($request->only('text'));
        } catch (\Exception $ex) {
            return back()->withErrors($ex->getMessage());
        }
    }
}
