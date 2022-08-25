<?php

namespace App\Services;

use App\OnlineServiceHistory;
use Illuminate\Support\Facades\Config;

class SummarizeService
{
    protected $summarize;
    protected $APIService;
    private $url;
    private $host;
    private $header_content;
    private $key;

    public function __construct(MultipleAPIService $APIService, OnlineServiceHistory $summarize)
    {
        $this->summarize = $summarize;
        $this->APIService = $APIService;
        $this->url = 'https://text-summarizer1.p.rapidapi.com/summarize';
        $this->host = 'text-summarizer1.p.rapidapi.com';
        $this->header_content  = 'application/json';
        $this->key = Config::get('API_Keys.SummarizeAPIKey');;
    }


    public function summarizer($data)
    {
        return $this->APIService->post($this->host, $this->key, $this->header_content, $this->url, $data);
    }

    public function insertLog($user_id,$service_id)
    {
        return  $this->APIService->trigEvent($this->summarize, $user_id, $service_id);
    }

}
