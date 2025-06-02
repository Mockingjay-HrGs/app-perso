<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventRepository;


final class EventController extends AbstractController
{
    #[Route('/evenement/{slug}', name: 'event_show')]
    public function show(string $slug, EventRepository $eventRepo): Response
    {
        $event = $eventRepo->findOneBy(['slug' => $slug]);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'ticketTypes' => $event->getTicketTypes(),
        ]);
    }
}
