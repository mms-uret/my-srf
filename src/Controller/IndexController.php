<?php

namespace App\Controller;

use App\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(HttpClientInterface $httpClient, ArticleService $articleService): Response
    {
        $response = $httpClient->request('GET', 'https://srgrecrec.herokuapp.com/initial')->toArray();
        $articles = $articleService->enrichRecommenderInfos($response['results'][0]['recommendations']);
        return $this->render('base.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/rate/{id}/{rating}", name="rate")
     */
    public function rate(int $id, int $rating, SessionInterface $session)
    {
        $articles = $session->get('articles', []);
        $articles[] = ['id' => $id, 'rating' => $rating];
        $session->set('articles', $articles);

        return $this->json(['msg' => 'article recorded', 'count' => count($articles), 'articles' => $articles]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(SessionInterface $session, HttpClientInterface $httpClient)
    {
        $articles = $session->get('articles');
        $response = $httpClient->request('GET', 'https://my-srf.herokuapp.com/recommender/author', ['json' => $articles]);
        $session->set('articles', []);
        return $this->render('base.html.twig', ['recommender' => $response->toArray()]);
    }
}
