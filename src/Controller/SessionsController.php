<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionsController extends AbstractController
{
    #[Route('/sessions', name: 'app_sessions')]
    public function index(): Response
    {
        return $this->render('sessions/index.html.twig', [
            'controller_name' => 'SessionsController',
        ]);
    }
}
