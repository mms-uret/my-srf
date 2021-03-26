<?php


namespace App;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleService
{
    private HttpClientInterface $httpClient;
    private ParameterBagInterface $parameterBag;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $parameterBag)
    {
        $this->httpClient = $httpClient;
        $this->parameterBag = $parameterBag;
    }

    public function info(int $id): array
    {
        return $this->httpClient->request('GET', 'https://www.srf.ch/articleinfo/' . $id)->toArray();
    }

    public function seed(int $count = 10): array
    {
        $ids = explode(",", $this->parameterBag->get('ids'));
        shuffle($ids);
        $ids = array_slice($ids, 0, $count);
        return array_map(fn($id) => ['id' => $id, 'certainty' => 1, 'reason' => 'Random'], $ids);
    }

    public function enrichRecommenderInfos(array $articles): array
    {
        return array_map(fn ($article) => ['id' => $article['id'], 'certainty' => $article['certainty'], 'reason' => $article['reason'], 'info' => $this->info($article['id'])], $articles);
    }
}