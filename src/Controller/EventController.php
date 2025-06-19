<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends AbstractController
{
    #[Route('/evenement/{slug}', name: 'event_show')]
    public function show(
        string $slug,
        EventRepository $eventRepo,
        TicketRepository $ticketRepo
    ): Response {
        $event = $eventRepo->findOneBy(['slug' => $slug]);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        $ticketTypes = $event->getTicketTypes();

        $ticketTypeData = [];

        foreach ($ticketTypes as $ticketType) {
            $available = $ticketRepo->count([
                'ticketType' => $ticketType,
                'status' => 'disponible'
            ]);

            $ticketTypeData[] = [
                'ticketType' => $ticketType,
                'available' => $available,
            ];
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'ticketTypes' => $ticketTypeData,
        ]);
    }
}
