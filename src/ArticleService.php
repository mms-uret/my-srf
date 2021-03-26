<?php


namespace App;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function info(int $id): array
    {
        return $this->httpClient->request('GET', 'https://www.srf.ch/articleinfo/' . $id)->toArray();
    }

    public function enrichRecommenderInfos(array $articles): array
    {
        return array_map(fn ($article) => ['id' => $article['id'], 'certainty' => $article['certainty'], 'reason' => $article['reason'], 'info' => $this->info($article['id'])], $articles);
    }
}