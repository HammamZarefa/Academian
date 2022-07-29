<?php

namespace App\Services;

use App\Paraphrase;
use Illuminate\Support\Facades\Http;

class ParaphraseService
{
    protected $paraphrase;
    protected $APIService;
    private $url = 'https://rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com/rewrite';
    private $host = 'rewriter-paraphraser-text-changer-multi-language.p.rapidapi.com';
    private $header_content = 'application/json';
    private $key;

    public function __construct(MultipleAPIService $APIService, Paraphrase $paraphrase)
    {
        $this->paraphrase = $paraphrase;
        $this->APIService = $APIService;
        $this->key = config('API_Keys.ParaphraseAPIKey');
    }


    public function paraphrase($data)
    {
        return $response = $this->APIService->post($this->host, $this->key, $this->header_content, $this->url, $data);
//        json_decode($response, true);
//        return Config('plagiarisim-response');

    }

}
