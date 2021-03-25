<?php


namespace App;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function info(int $id): array
    {
        return $this->httpClient->request('get', 'https://www.srf.ch/articleinfo/' . $id)->toArray();
    }
}