<?php

namespace App\Controller;


use Symfony\Component\Mime\Email;
use App\Repository\ProductRepository;
use App\Repository\CategoryParentRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    function index(ProductRepository $productRepository, CategoryParentRepository $categoryP, CartService $cartService): Response
    {
        $products = $productRepository->findAll();
        $cartS = $cartService->getFullCart();
        $products = $productRepository->findBy(
            [],
            [
                "name" => "ASC",
            ],
            4,
            0
        );

        $catep = $categoryP->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categoryps' => $catep,
            'items' => $cartS,

        ]);
    }
}
