<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $event = new Event();
        $form = $this->createForm(EventType::class, $event, [
            'action' => $this->generateUrl('event_new')
        ]);

        return $this->render('event/index.html.twig', [
            'numeros' => [1, 2, 3, 4, 5],
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $createdDate = new DateTime("NOW");
        $event = new Event();
        $user = new User();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $response = [];
        $user = $this->getUser();
        // var_dump($userId);
        // die;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $event->setCreatedDate($createdDate);
            // dump($user->getId());
            // die;
            $event->setIdUser($user);
            try {
                // Controlar si existe el email
                $entityManager->persist($event);
                $entityManager->flush();
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['error'] = $e->getMessage();
                $response['message'] = 'Error al crear el partido';
                return new JsonResponse($response);
            }
            $response['success'] = true;
            $response['message'] = true;
        }
        return new JsonResponse($response);
        // return $this->render('user/new.html.twig', [
        //     'form' => $form->createView(),
        //     'response' => $response
        // ]);
    }
}
