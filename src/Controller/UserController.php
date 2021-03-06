<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/register", name="user_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $success = false;
        $registerDate = new DateTime();
        $registerDate->format('Y-m-d H:i:s');

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            $user->setRoles(['ROLE_USER']);
            $password = $form['password']->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $user->setIsBanned(false);
            $user->setIsActive(true);
            $user->setRegisterDate($registerDate);
            $user = $form->getData();
            try {
                // Controlar si existe el email
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $success = false;
                $this->addFlash('register_info', 'No se ha podido completar el registro, intentelo de nuevo mas tarde');
                return $this->redirectToRoute('user_new');
            }
            $success = true;
            // Limipio el form y el objeto user (reinicializo)
            unset($entity);
            unset($form);
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $this->addFlash('register_info', '¡Te has registrado correctamente!');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }


    /**
     * @Route("/profile", name="user_profile", methods={"GET", "POST"})
     */
    public function profile(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form['password']->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $password));
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
