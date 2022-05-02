<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MentionController extends AbstractController
{
    #[Route('/mention-legales', name: 'app_mention')]
    public function index(CartService $cartService): Response
    {
        return $this->render('mention/index.html.twig', [
            'controller_name' => 'MentionController',
            'items' => $cartService->getFullCart(),

        ]);
    }
}
