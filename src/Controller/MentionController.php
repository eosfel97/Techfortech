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
    #[Route('/nos-conditions-generales-de-vente', name: 'app_cgv')]
    public function cgv(CartService $cartService): Response
    {
        return $this->render('mention/cgv.html.twig', [
            'controller_name' => 'MentionController',
            'items' => $cartService->getFullCart(),

        ]);
    }
    #[Route('/Politique de Confidentialité', name: 'app_polity')]
    public function polity(CartService $cartService): Response
    {
        return $this->render('mention/polity.html.twig', [
            'controller_name' => 'MentionController',
            'items' => $cartService->getFullCart(),

        ]);
    }
}
