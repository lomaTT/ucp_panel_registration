<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login_index', methods: ['GET'])]
    public function index(Security $security): Response
    {
        // TODO: REFACTOR TO METHOD isUser
        if (!empty($security->getUser()) && in_array("ROLE_USER", $security->getUser()->getRoles())) {
            return $this->redirect('/profile');
        }

        // TODO: REFACTOR TO METHOD isAdmin
        if (!empty($security->getUser()) && in_array("ROLE_ADMIN", $security->getUser()->getRoles())) {
            return $this->redirect('/admin/profile');
        }

        $form = $this->createForm(LoginType::class);

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response
    {
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $findedUser = $entityManager->getRepository(User::class)->findOneBy(
                ['username' => $form->get('username')->getData()]
            );

            $isPasswordValid = $passwordHasher->isPasswordValid($findedUser, $form->get('password')->getData());
            if ($isPasswordValid) {
                return $security->login(user: $findedUser);
            } else {
                return $this->render('login/index.html.twig', [
                    'controller_name' => 'LoginController',
                    'form' => $form,
                ]);
            }
        }

        return new Response("You need your browser to log in!");
    }
}
