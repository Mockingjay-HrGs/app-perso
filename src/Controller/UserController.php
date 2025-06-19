<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(TicketRepository $ticketRepository, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $tickets = $ticketRepository->findBy(['user' => $user]);

        return $this->render('user/profile.html.twig', [
            'tickets' => $tickets
        ]);
    }

    #[Route('/profil/ticket/{id}/delete', name: 'app_ticket_delete')]
    public function deleteTicket(
        Ticket $ticket,
        Security $security,
        EntityManagerInterface $entityManager
    ): RedirectResponse {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour supprimer un billet.');
        }

        if ($ticket->getUser() !== $user) {
            throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres billets.');
        }

        if ($ticket->getStatus() !== 'payé') {
            $this->addFlash('error', 'Seuls les billets payés peuvent être supprimés.');
            return $this->redirectToRoute('app_profile');
        }

        $entityManager->remove($ticket);
        $entityManager->flush();

        $this->addFlash('success', 'Billet supprimé avec succès.');

        return $this->redirectToRoute('app_profile');
    }
}
