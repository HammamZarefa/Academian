<?php

namespace App\Services;

use App\OnlineServiceHistory;

class PlagiarismService
{
    public $plagiarism;
    public $APIService;
    public $url ;
    public $host ;
    public $header_content ;
    public $key ;

    public function __construct(MultipleAPIService $APIService, OnlineServiceHistory $plagiarism)
    {
        $this->plagiarism = $plagiarism;
        $this->APIService = $APIService;
        $this->url = 'https://plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com/plagiarism';
        $this->host = 'plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com';
        $this->header_content  = 'application/json';
        $this->key = config('PlagiarismAPIKey'.'PlagiarismAPIKey');

    }

    public function detectPlagiarism($data)
    {
         return  $this->APIService->post($this->host, 'ebf6d183c0msh3bf0715e35149d3p1c098cjsnf11a02e84fd5', $this->header_content, $this->url, $data);
    }

    public function insertLog($user_id,$service_id)
    {
        return  $this->APIService->trigEvent($this->plagiarism, $user_id, $service_id);
    }

}
