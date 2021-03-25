<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecommenderController extends AbstractController
{
    /**
     * @Route("/recommender/author", name="recommender_author")
     */
    public function author(): Response
    {
        return $this->json([
            'name' => 'author_recom',
            'reason' => 'Aufgrund Ihrer Angaben, Popularität und Aktualität werden Ihnen die Artikel von [Platzhalter siehe Reason unten] angezeigt.',
            'certainty' => 1,
            'articles' => [
                0 => [
                    'id' => 19545671,
                    'certainty' => 0.6290087797531265,
                    'reason' => 'Peter Fritsche',
                ],
                1 => [
                    'id' => 19548257,
                    'certainty' => 0.6078855789610188,
                    'reason' => 'Dario Pelosi',
                ],
                2 => [
                    'id' => 19546865,
                    'certainty' => 0.388069011564527,
                    'reason' => 'Marielle Gygax',
                ],
                3 => [
                    'id' => 19510364,
                    'certainty' => 0.3545522240208885,
                    'reason' => 'Dario Pelosi',
                ],
                4 => [
                    'id' => 19553900,
                    'certainty' => 0.32489756575980105,
                    'reason' => 'Dario Pelosi',
                ],
                5 => [
                    'id' => 19489481,
                    'certainty' => 0.293741931031462,
                    'reason' => 'Peter Fritsche',
                ],
                6 => [
                    'id' => 19467500,
                    'certainty' => 0.2746112166143708,
                    'reason' => 'Benjamin Hostettler',
                ],
                7 => [
                    'id' => 19465592,
                    'certainty' => 0.2628699385891371,
                    'reason' => 'Peter Fritsche',
                ],
                8 => [
                    'id' => 19451755,
                    'certainty' => 0.22968875061756835,
                    'reason' => 'Peter Fritsche',
                ],
                9 => [
                    'id' => 19452205,
                    'certainty' => 0.22546642646038853,
                    'reason' => 'David Karasek',
                ],
            ],
        ]);
    }
}