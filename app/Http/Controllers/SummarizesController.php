<?php

namespace App\Http\Controllers;

use App\Http\Requests\SummarizeRequest;
use App\Services\SummarizeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class SummarizesController extends Controller
{
    protected $service;

    public function __construct(SummarizeService $service)
    {
        $this->middleware(['check_subscription:2'])->only('index');

        $this->service = $service;
    }

    public function index()
    {
        return view('summarize.index');
    }

    public function detect(SummarizeRequest $request)
    {
        try {
            $userId = auth()->user()->id;
            $request->validated();
            $data = [
                "_token" => $request->_token,
                "text" => $request->text,
                "language" => $request->language,
                "output_sentences" => (integer)$request->output_sentences
            ];
            $response = $this->service->summarizer($data); // integrate with multiple APIs summarize
            if (!$response ){
                return back()->withErrors('This service is not available in your location');
            }else
            session()->flashInput($request->input());
            $string = Str::of($response['summary'])->explode(' ');
            $countRequest = Str::of($request->text)->explode(' ')->count();
            $count = $string->count();
            $this->service->insertLog($userId, 1); // trigger event to new insert in log of Summarize
            return view('summarize.index',
                compact('response', 'count', 'countRequest'))
                ->withInput($request->only('text'));
        } catch (\Exception $ex) {
            return back()->withErrors($ex->getMessage());
        }
    }
}
