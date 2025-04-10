<?php

namespace App\Service\Cart;

use App\Entity\Purchase;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;


class CartService
{
    protected $session;
    protected $productRepository;


    public function __construct(RequestStack $sessionstack, ProductRepository $productRepository)
    {
        $session = $sessionstack->getSession();
        $this->session = $session;
        $this->productRepository = $productRepository;
    }



    public function add(int  $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }


    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }



    public function getTotal(): float
    {

        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }

    public function less(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (($panier[$id]) < 2) {
            unset($panier[$id]);
        } else {
            $panier[$id]--;
        }
        $this->session->set('panier', $panier);
    }
}
