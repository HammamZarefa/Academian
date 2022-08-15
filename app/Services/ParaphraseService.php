<?php

namespace App\Services;

use App\OnlineServiceHistory;

class ParaphraseService
{
    protected $paraphrase;
    protected $APIService;
    private $url = 'https://rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com/rewrite';
    private $host = 'rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com';
    private $header_content = 'application/json';
    private $key;

    public function __construct(MultipleAPIService $APIService, OnlineServiceHistory $paraphrase)
    {
        $this->paraphrase = $paraphrase;
        $this->APIService = $APIService;
        $this->key = config('API_Keys.ParaphraseAPIKey');
    }


    public function paraphrase($data)
    {
        return $this->APIService->post($this->host, $this->key, $this->header_content, $this->url, $data);

    }

    public function insertLog($user_id, $service_id)
    {
        return $this->APIService->trigEvent($this->paraphrase, $user_id, $service_id);
    }

}
