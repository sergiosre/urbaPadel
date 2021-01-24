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
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/event")
 */

class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $today = new DateTime("NOW");
        $today = $today->format('Y-m-d H:i');
        $events = $eventRepository->getEvents($today);
        $event = new Event();
        $form = $this->createForm(EventType::class, $event, [
            'action' => $this->generateUrl('event_new')
        ]);
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
            $date = $form['date']->getData() . " " . $form['hour']->getData();
            $event->setCreatedDate($createdDate);
            $event->setDate($date);
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
        $response = new JsonResponse($response);
        return $this->redirectToRoute('event_index');
    }

    /**
     * @Route("/join-event", name="event_join", options={"expose"=true}, methods={"POST"},)
     */
    public function joinEvent(Request $request, EntityManagerInterface $entityManager, EventRepository $eventRepository): JsonResponse
    {

        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();
            $eventId = $request->get('eventId');
            // TODO: Recoger que en que posicion de jugador se inscribe
            // $playerNumber = $request->get('playerNumber');

            $userLogedSignedInEvent = $eventRepository->checkIfPlayerIsInEvent($eventId, $user->getId());
            if (!$userLogedSignedInEvent) {
                $event = $eventRepository->find($eventId);
                $event->setPlayer2($user);
                $entityManager->flush();
                $response = [
                    'success' => true,
                    'message' => '¡Inscripción al partido realizada!'
                ];
                return new JsonResponse($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => '¡Ya estas inscrito en el partido, no puedes volver a inscribirte!'
                ];
                return new JsonResponse($response);
            }
        }
        $response = [
            'success' => false,
            'message' => '¡Error al inscribirte en el partido!'
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/exit-event", name="event_exit", options={"expose"=true}, methods={"POST"},)
     */
    public function exitEvent(Request $request, EntityManagerInterface $entityManager, EventRepository $eventRepository): JsonResponse
    {

        if ($request->isXmlHttpRequest()) {
            $eventId = $request->get('eventId');
            $playerNumber = $request->get('playerPosition');
            // TODO: Verificar si el jugador q
            $userLogedSignedInEvent = $eventRepository->checkIfPlayerIsInEvent($eventId, $user->getId());
            if (!$userLogedSignedInEvent) {
                $event = $eventRepository->find($eventId);
                $event->setPlayer2(NULL);
                $entityManager->flush();
                $response = [
                    'success' => true,
                    'message' => '¡Inscripción al partido realizada!'
                ];
                return new JsonResponse($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => '¡Ya estas inscrito en el partido, no puedes volver a inscribirte!'
                ];
                return new JsonResponse($response);
            }
        }
        $response = [
            'success' => false,
            'message' => '¡Error al inscribirte en el partido!'
        ];
        return new JsonResponse($response);
    }
}
