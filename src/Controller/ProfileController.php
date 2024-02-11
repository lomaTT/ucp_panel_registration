<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'index_profile', methods: ['GET'])]
    public function index(Security $security): Response
    {

//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $security->getUser();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
