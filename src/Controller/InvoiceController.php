<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Invoice;
use App\Entity\Product;
use App\Entity\Purchases;
use App\Form\InvoiceType;
use App\Service\Cart\CartService;
use App\Repository\InvoiceRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchasesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/Facturation')]
class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
    #[Route('/Info', name: 'invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SessionInterface $session, CartService $cartService, ManagerRegistry $doctrine, ProductRepository $productRepository): Response
    {
        $invoice = new Invoice();
        /** @var User $user */
        $user = $this->getUser();
        $total = $cartService->getTotal();

        if ($user) {
            $invoice->setName($user->getLastname())
                ->setFirstname($user->getFirstname())
                ->setZipCode($user->getZipCode())
                ->setCountry($user->getCountry())
                ->setTown($user->getTown())
                ->setAddress($user->getAddress());
        } else {
            $this->addFlash('danger', "Vous devez creer un compte pour passer une commande");
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Doctrine $doctrine */
            $entityManager = $doctrine->getManager();
            $invoice->setTotalPrice($total)
                ->setPiStripe("")
                ->setPaid(false)
                ->setStripeSuccessKey(uniqid());
            $entityManager->persist($invoice);
            $panier = $session->get('panier', []);
            foreach ($panier as $id => $quantity) {
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
            return $this->redirectToRoute('stripe_checkout', ["invoice" => $invoice->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        ]);
    }
    #[Route('/{id}/show', name: 'invoice_show', methods: ['GET'])]
    // #[Entity('purchases', options: ["id" => "product_id"])]
    public function show(Invoice $invoice, Product $product): Response
    {

        $user = $this->getUser();
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
            'products' => $product,
            'user' => $user,
        ]);
    }
    #[Route('/{id}/Commandes', name: 'invoice_user_invoice', methods: ['GET', 'POST'])]
    public function userInvoice(InvoiceRepository $invoice): Response
    {
        $user = $this->getUser();
        return $this->render('invoice/user_invoice.html.twig', [
            'invoices' => $invoice->findAll(),
            'user' => $user,
        ]);
    }
}
