<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register_index', methods: ["GET"])]
    public function index(): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form' => $form,
        ]);
    }

    #[Route('/register', name: 'register', methods: ["POST"])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $registrationDate = date("Y-m-d H:i:s");
            $user->setRegisterDate(new DateTime($registrationDate));

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );

            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            return new Response(
                "Oh my, " . $user->getUsername() . " is registered!"
            );
        }

        return new Response(
            $form->getErrors()
        );
    }
}
