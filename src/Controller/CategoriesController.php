<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(
        CategoryRepository $categoryRepository,
        EventRepository $eventRepository,
        Request $request
    ): Response {
        $categories = $categoryRepository->findAll();

        // ✅ Récupère ?q= depuis l'URL
        $query = $request->query->get('q');

        if ($query) {
            // ✅ Requête filtrée avec Doctrine DQL
            $events = $eventRepository->createQueryBuilder('e')
                ->where('LOWER(e.title) LIKE :q')
                ->setParameter('q', '%' . strtolower($query) . '%')
                ->getQuery()
                ->getResult();
        } else {
            $events = $eventRepository->findAll();
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'events' => $events,
            'query' => $query // ✅ Pour pré-remplir l'input
        ]);
    }

    #[Route('/categories/{slug}', name: 'app_category_detail')]
    public function showCategory(string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie introuvable');
        }

        $events = $category->getEvents();

        return $this->render('categories/detail.html.twig', [
            'category' => $category,
            'events' => $events,
        ]);
    }

    #[Route('/super-admin/dashboard', name: 'app_super_admin_dashboard')]
    public function dashboard(): Response
    {
        dd('connecté en tant que super admin');
    }
}
