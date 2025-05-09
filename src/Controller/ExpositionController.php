<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExpositionController extends AbstractController
{
    #[Route('/exposition', name: 'app_exposition')]
    public function index(): Response
    {
        return $this->render('exposition/index.html.twig', [
            'controller_name' => 'ExpositionController',
        ]);
    }
}
