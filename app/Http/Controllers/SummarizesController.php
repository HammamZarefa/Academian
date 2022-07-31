<?php

namespace App\Http\Controllers;

use App\Http\Requests\SummarizeRequest;
use App\Services\SummarizeService;
use Illuminate\Support\Str;

class SummarizesController extends Controller
{
    protected $service;

    public function __construct(SummarizeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('summarize.index');
    }

    public function detect(SummarizeRequest $request)
    {
        try {
            $data = $request->validated();
            return $response = $this->service->summarizer($data);
            session()->flashInput($request->input());
            $string = Str::of($response['summary'])->explode(' ');
            $countRequest = Str::of($request->summary)->explode(' ')->count();
            $count = $string->count();
            return view('summarize.index',
                compact('response', 'count', 'countRequest'))
                ->withInput($request->only('text'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
