<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll(); // ← On récupère les catégories

        return $this->render('categories/index.html.twig', [
            'categories' => $categories, // ← On les envoie à la vue
        ]);
    }

    #[Route('/categories/{slug}', name: 'app_category_detail')]
    public function showCategory(string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie introuvable');
        }

        $events = $category->getEvents(); // Cette méthode doit exister dans ton entité

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
