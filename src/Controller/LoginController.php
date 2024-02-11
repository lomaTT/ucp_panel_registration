<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $user = new User();
        $user->setUsername('test');
        $user->setPassword('2131');

        $form = $this->createForm(LoginType::class, $user);

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return new Response(
                "Nice request!"
            );
        } else {
            return new Response(
                "Bad request!"
            );
        }
    }
}
