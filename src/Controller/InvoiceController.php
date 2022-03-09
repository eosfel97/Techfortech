<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\Purchases;
use App\Form\InvoiceType;
use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
    #[Route('/invoice', name: 'invoice_new', methods: ['GET', 'POST'])]
   public function new(Request $request,SessionInterface $session,CartService $cartService,ManagerRegistry $doctrine,ProductRepository $productRepository  ): Response
   {
        $invoice = new Invoice();
        /** @var User $user */
        $user = $this->getUser();
        $total= $cartService->getTotal();

        if($user)
        {
            $invoice->setName($user->getLastname())
                  ->setFirstname($user->getFirstname())
                  ->setZipCode($user->getZipCode())
                  ->setCountry($user->getCountry())
                  ->setTown($user->getTown())
                  ->setAddress($user->getAddress());

        }
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            /** @var Doctrine $doctrine */
            $entityManager = $doctrine->getManager();
            $invoice->setTotalPrice($total)
                    ->setPiStripe("")
                  ->setPaid(false)
                  ->setStripeSuccessKey(uniqid());
            $entityManager->persist($invoice);
            $panier = $session->get('panier',[]);
            foreach($panier as $id => $quantity)
            {
            $product = $productRepository->find($id);
            $purchase = new Purchases;
            $purchase->setInvoice($invoice)
                    ->setProduct($product)
                    ->setUnitPrice($product->getPrice())
                    ->setQuantity($quantity);
            $entityManager->persist($purchase);
            }
            // dd($invoice);
            $entityManager->flush();
            return $this->redirectToRoute('stripe_checkout', ["invoice"=>$invoice->getId()], Response::HTTP_SEE_OTHER);
        }
       return $this->renderForm('invoice/new.html.twig', [
        'invoice' => $invoice,
            'form' => $form,
            'items' => $cartService->getFullCart(),
            'total'=> $cartService->getTotal(),
       ]);
    }
}
