<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Invoice;
use App\Repository\PurchasesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/{invoice}/stripe', name: 'stripe_checkout')]
    public function checkout(Invoice $invoice, PurchasesRepository $purchasesRepo, Request $request, EntityManagerInterface $em): Response
    {
        $privateKey = "sk_test_51KX6uPAXs1xr62PHMRfRVmUMHdb6KD7OnCVB2ddaVxIeDZVRRBL4lIZjfCAgwb5j00TOUDfZbScoFuym4WFmnVhe00ZDBwXT1U";
        Stripe::setApiKey($privateKey);
        $purchaseCriteria = [
            "invoice" => $invoice,
        ];
        $purchases = $purchasesRepo->findBy($purchaseCriteria);
        $lineItems = [];
        foreach ($purchases as $purchase) {
            $item = [
                "price_data" => [
                    "currency" => "eur",
                    "product_data" => [
                        "name" => $purchase->getProduct()->getName(),
                    ],
                    "unit_amount" => $purchase->getUnitPrice(),
                ],
                "quantity" => $purchase->getQuantity(),
            ];
            $lineItems[] = $item;
        }
        $successRoute = $this->generateUrl('stripe_valid_payment', [
            "_locale" => $request->getLocale(),
            "invoice" => $invoice->getId(),
            "stripeSuccessKey" => $invoice->getStripeSuccessKey(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        $errorRoute = $this->generateUrl('stripe_error_payment', [
            "_locale" => $request->getLocale(),
            "invoice" => $invoice->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        $stripeSession = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url' => $successRoute,
            'cancel_url' => $errorRoute,
        ]);
        $invoice->setPiStripe($stripeSession->payment_intent);
        $em->flush($invoice);
        return $this->redirect($stripeSession->url, 303);
    }
    #[Route("/stripe/{invoice}/succes/{stripeSuccessKey}", name: 'stripe_valid_payment')]
    public function success(Invoice $invoice, string $stripeSuccessKey, SessionInterface $session, PurchasesRepository $purchasesRepo): Response
    {
        if ($stripeSuccessKey != $invoice->getStripeSuccessKey()) {
            $this->redirectToRoute("stripe_error_payment", [
                'invoice' => $invoice->getId(),
            ]);
        }
        $invoice->setPaid(true);
        $session->set('panier', []);
        $purchaseCriteria = [
            "invoice" => $invoice,
        ];
        $purchases = $purchasesRepo->findBy($purchaseCriteria);
        $this->addFlash('success', "Votre commande a été valider");
        // dd($session);
        return $this->render('stripe/success.html.twig', [
            'invoice' => $invoice,
            'purchases' => $purchases,
        ]);
    }
    #[Route("/stripe/{invoice}/annulation", name: 'stripe_error_payment')]
    public function error(Invoice $invoice): Response
    {
        $this->addFlash("danger", "Le payment a éte refuser");
        return $this->redirectToRoute("cart_show");
    }
}
