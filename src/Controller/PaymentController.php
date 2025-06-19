<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/paiement/{id}', name: 'app_ticket_pay')]
    public function pay(
        TicketType $ticketType,
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour acheter un billet.');
            return $this->redirectToRoute('app_login');
        }

        // ✅ Cherche un Ticket EXISTANT, disponible pour ce type
        $ticket = $em->getRepository(Ticket::class)->findOneBy([
            'ticketType' => $ticketType,
            'status' => 'disponible',
        ]);

        if (!$ticket) {
            $this->addFlash('error', 'Plus de billet disponible pour ce type.');
            return $this->redirectToRoute('event_show', [
                'slug' => $ticketType->getEvent()->getSlug(),
            ]);
        }

        // ✅ Réserve ce ticket
        $ticket->setUser($user);
        $ticket->setStatus('payé');

        $em->flush();

        $this->addFlash('success', 'Billet ajouté à votre profil !');

        return $this->redirectToRoute('app_profile');
    }
}
