<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryParent;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryParentController extends AbstractController
{
    #[Route('/parent', name: 'app_category_parent')]
    public function index(): Response
    {
        return $this->render('category_parent/index.html.twig', [
            'controller_name' => 'CategoryParentController',
        ]);
    }

    #[Route('/{id}', name: 'categoryp_show', methods: ['GET', 'POST'])]
    public function show(CategoryParent $categoryp, CategoryRepository $category): Response
    {
        $categories = $category->findBy([], [
            "category" => "ASC",
        ]);
        dd($categories, $categoryp);
        return $this->render('category_parent/show.html.twig', [
            'categoryp' => $categoryp,
            'categories' => $categories,
        ]);
    }
}
