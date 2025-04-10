<?php

namespace App\Controller;

use App\Entity\CategoryParent;
use App\Service\Cart\CartService;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/Category')]
class CategoryParentController extends AbstractController
{
    #[Route('/', name: 'app_category_parent')]
    public function index(CartService $cartService): Response
    {
        return $this->render('category_parent/index.html.twig', [
            'controller_name' => 'CategoryParentController',
            'items' => $cartService->getFullCart(),
        ]);
    }

    #[Route('/{name}', name: 'categoryp_show', methods: ['GET', 'POST'])]
    public function show(CategoryParent $categoryp, CategoryRepository $category, CartService $cartService): Response
    {
        $categories = $category->findBy([], [
            "category" => "ASC",
        ]);
        // dd($categories);
        return $this->render('category_parent/show.html.twig', [
            'categoryps' => $categoryp,
            'categories' => $categories,
            'items' => $cartService->getFullCart(),

        ]);
    }
}
