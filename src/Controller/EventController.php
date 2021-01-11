<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\EventRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        $event = new Event();
        $form = $this->createForm(EventType::class, $event, [
            'action' => $this->generateUrl('event_new')
        ]);
        // dump($events);
        // die;
        return $this->render('event/index.html.twig', [
            'events' => $events,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $createdDate = new DateTime("NOW");
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $response = [];
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedDate($createdDate);
            $event->setPlayer1($user);
            $event->setUser($user);
            try {
                $entityManager->persist($event);
                $entityManager->flush();
            } catch (\Exception $e) {
                $response['success'] = false;
                $response['error'] = $e->getMessage();
                $response['message'] = 'Error al crear el partido';
                return new JsonResponse($response);
            }
            $response['success'] = true;
            $response['message'] = '¡Partido creado correctamente!';
        }
        return new JsonResponse($response);
        // return $this->render('user/new.html.twig', [
        //     'form' => $form->createView(),
        //     'response' => $response
        // ]);
    }
}
