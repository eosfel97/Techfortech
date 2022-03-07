<?php

namespace App\Controller;


use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    
    #[Route('/panier', name: 'cart_index')]
    
    public function index(CartService $cartService): Response
    {   
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total'=> $cartService->getTotal()
        ]);
    }
    #[Route('/panier/add/{id}', name: 'cart_add')]
    
    public function add( $id, CartService $cartService)    
    {
        $cartService->add($id);
        return $this->redirectToRoute("cart_index");
    }
    
    
    
    #[Route('/panier/remove/{id}', name: 'cart_remove')]
    
    public function remove($id, CartService $cartService){
        $cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }

    #[Route('/panier/less/{id}', name: 'cart_less')]  
    public function less( $id, CartService $cartService)    
    {
        $cartService->less($id);
        return $this->redirectToRoute("cart_index");
    }
}