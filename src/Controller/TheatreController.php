<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TheatreController extends AbstractController
{
    #[Route('/theatre', name: 'app_theatre')]
    public function index(): Response
    {
        return $this->render('theatre/index.html.twig', [
            'controller_name' => 'TheatreController',
        ]);
    }
}
