<?php

namespace App\Services;

use App\Paraphrase;
use App\Summarize;
use Illuminate\Support\Facades\Http;

class SummarizeService
{
    protected $summarize;
    protected $APIService;
    private $url = 'https://text-summarizer1.p.rapidapi.com/summarize';
    private $host = 'text-summarizer1.p.rapidapi.com';
    private $header_content = 'application/json';
    private $key;

    public function __construct(MultipleAPIService $APIService, Summarize $summarize)
    {
        $this->summarize = $summarize;
        $this->APIService = $APIService;
        $this->key = config('API_Keys.SummarizeAPIKey');
    }


    public function summarizer($data)
    {
        return $this->APIService->post($this->host, $this->key, $this->header_content, $this->url, $data);
    }

}
