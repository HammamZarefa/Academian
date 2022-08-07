<?php

namespace App\Services;

use App\Events\PlagiarsmCountRequestEvent;
use App\Plagiarism;

class PlagiarismService
{
    public $plagiarism;
    public $APIService;
    public $url ;
    public $host ;
    public $header_content ;
    public $key ;

    public function __construct(MultipleAPIService $APIService, Plagiarism $plagiarism)
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
         return  $this->APIService->post($this->host, $this->key, $this->header_content, $this->url, $data);
    }

    public function trigEvent($userId)
    {
        event(new PlagiarsmCountRequestEvent($this->plagiarism, $userId));
    }

}
