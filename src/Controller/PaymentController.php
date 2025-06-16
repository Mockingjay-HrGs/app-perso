<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PaymentController extends AbstractController
{
    #[Route('/paiement/{id}', name: 'app_ticket_pay')]
    public function pay(
        TicketType             $ticketType,
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();

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
        $ticket->setStatus('paid');

        $em->persist($ticket);
        $em->flush();

        $this->addFlash('success', 'Billet ajouté à votre profil !');

        return $this->redirectToRoute('app_profile');
    }
}
