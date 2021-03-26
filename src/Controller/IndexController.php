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
        //$response = $httpClient->request('GET', 'https://srgrecrec.herokuapp.com/recommend', ['json' => ['ratings' => $articles]])->toArray();
        $response = json_decode('{"results":[{"certainty":1,"name":"author_recom","reason":"Aufgrund Ihrer Angaben, Popularit\u00e4t und Aktualit\u00e4t werden Ihnen die Artikel von [Platzhalter siehe Reason unten] angezeigt.","recommendations":[{"certainty":0.4157407859793164,"id":19547282,"reason":"Fredy Gsteiger"},{"certainty":0.3413828763626245,"id":19528364,"reason":"Fredy Gsteiger"},{"certainty":0.3124960605636014,"id":19485347,"reason":"Fredy Gsteiger"},{"certainty":0.2117153442680964,"id":19436680,"reason":"Fredy Gsteiger"},{"certainty":0.1673923134246148,"id":19523342,"reason":"Fredy Gsteiger"},{"certainty":0.1632245963065603,"id":19332721,"reason":"Fredy Gsteiger"},{"certainty":0.147897926135203,"id":19306267,"reason":"Pius Kessler"},{"certainty":0.1442287372150965,"id":19407484,"reason":"Fredy Gsteiger"},{"certainty":0.1436292491559656,"id":19347679,"reason":"Dennis Hoffmeyer"},{"certainty":0.1300870453960978,"id":19387615,"reason":"Fredy Gsteiger"}]}]}', true);


        return $this->render('result.html.twig', ['recommenders' => $response['results']]);
    }
}
