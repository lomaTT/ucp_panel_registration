<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'logout', methods: ["GET"])]
    public function index(Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        // TODO: enable CSRF verification in config files
        $response = $security->logout(false);

        return $this->redirect('/');
    }
}
