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

    public function detect(Request $request)
    {
        try {
            $data = ["_token"=>$request->_token,
                "text"=>$request->text,
                "language"=>$request->language,
                "output_sentences"=>(integer)$request->output_sentences];
             $response = $this->service->summarizer($data);
            session()->flashInput($request->input());
            $string = Str::of($response['summary'])->explode(' ');
            $countRequest = Str::of($request->text)->explode(' ')->count();
            $count = $string->count();
            return view('summarize.index',
                compact('response', 'count', 'countRequest'))
                ->withInput($request->only('text'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
