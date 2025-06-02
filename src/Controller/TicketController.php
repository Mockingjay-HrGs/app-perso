<?php

namespace App\Controller;

use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\EventRepository;
use App\Repository\TicketTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TicketController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/evenement/{eventSlug}/acheter/{ticketTypeId}', name: 'ticket_checkout')]
    public function checkout(
        string $eventSlug,
        int $ticketTypeId,
        EventRepository $eventRepo,
        TicketTypeRepository $typeRepo,
        EntityManagerInterface $em,
        Security $security
    ): Response {
        $event = $eventRepo->findOneBy(['slug' => $eventSlug]);
        $ticketType = $typeRepo->find($ticketTypeId);

        if (!$event || !$ticketType) {
            throw $this->createNotFoundException('Événement ou billet introuvable.');
        }

        $ticket = new Ticket();
        $ticket->setUser($security->getUser());
        $ticket->setEvent($event);
        $ticket->setTicketType($ticketType);
        $ticket->setCode(uniqid('TICKET-'));
        $ticket->setCreatedAt(new \DateTimeImmutable());
        $ticket->setStatus('payé');

        $em->persist($ticket);
        $em->flush();

        $this->addFlash('success', 'Billet acheté avec succès.');

        return $this->redirectToRoute('app_profile');
    }
}
