<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/profile', name: 'index_admin')]
    public function index(Security $security): Response
    {
        dd($security->getUser());
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
