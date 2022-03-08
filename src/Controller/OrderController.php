<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\Purchase;
use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order')]
    public function index(): Response
    {

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
   #[Route('/order', name: 'order_new', methods: ['GET', 'POST'])]
   public function new(Request $request,SessionInterface $session,CartService $cartService,EntityManagerInterface $entityManager,ProductRepository $productRepository  ): Response
   {
        $order = new Order();
        $user = $this->getUser();
        $total= $cartService->getTotal();

        if($user)
        {
            $order->setName($user->getLastname())
                  ->setFirstname($user->getFirstname())
                  ->setCountry($user->getCountry())
                  ->setZipCode($user->getZipCode())
                  ->setTown($user->getTown());
        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $order->setTotalPrice($total)
                  ->setPaid(false)
                  ->setStripeSuccesKeys(uniqid());
            $entityManager->persist($order);
            $panier = $session->get('panier',[]);
            foreach($panier as $id => $quantity)
            {
            $product =$this->$productRepository->find($id);
            $purchase = new Purchase;
            $purchase->setInvoice($order)
                    ->setProduct($product)
                    ->setUnitPrice($product->getPrice())
                    ->setQuantity($quantity);
            $entityManager->persist($purchase);
            }
            $entityManager->flush();
            return $this->redirectToRoute('stripe_checkout', ["order"=>$order->getId()], Response::HTTP_SEE_OTHER);
        }
       return $this->renderForm('order/new.html.twig', [
        'order' => $order,
            'form' => $form,
            'items' => $cartService->getFullCart(),
            'total'=> $cartService->getTotal(),
       ]);
    }
}