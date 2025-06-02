<?php

namespace App\Controller;

class PaymentController
{
    #[Route('/paiement/{id}', name: 'app_ticket_pay')]
    public function pay(TicketType $ticketType, EntityManagerInterface $em, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour acheter un billet.');
            return $this->redirectToRoute('app_login');
        }

        $ticket = new Ticket();
        $ticket->setUser($user);
        $ticket->setTicketType($ticketType);
        $ticket->setEvent($ticketType->getEvent());
        $ticket->setCode(uniqid('TICKET-'));
        $ticket->setCreatedAt(new \DateTimeImmutable());

        $em->persist($ticket);
        $em->flush();

        $this->addFlash('success', 'Paiement fictif réussi. Billet ajouté à votre profil !');

        return $this->redirectToRoute('app_profile');
    }

}