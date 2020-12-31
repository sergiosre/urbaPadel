<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */

class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'numeros' => [1, 2, 3, 4, 5],
        ]);
    }
}
