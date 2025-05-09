<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DanseController extends AbstractController
{
    #[Route('/danse', name: 'app_danse')]
    public function index(): Response
    {
        return $this->render('danse/index.html.twig', [
            'controller_name' => 'DanseController',
        ]);
    }
}
