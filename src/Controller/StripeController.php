<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{
    #[Route('/{order}/stripe', name: 'stripe_checkout')]
    public function checkout(Order $order, PurchaseRepository $purchaseRepository, Request $request, EntityManagerInterface $em): Response
    {
        $privateKey ="sk_test_51KX6uPAXs1xr62PHMRfRVmUMHdb6KD7OnCVB2ddaVxIeDZVRRBL4lIZjfCAgwb5j00TOUDfZbScoFuym4WFmnVhe00ZDBwXT1U";
        Stripe::setApiKey($privateKey);
        $purchaseCriteria = [
            "order"=>$order,
        ];
        $purchases = $purchaseRepository->findBy($purchaseCriteria);
        $lineItems = [];
        foreach ($purchases as $purchase){
            $item =[
                "price_data"=>[
                    "curency"=>"eur",
                    "product_data"=>[
                        "name"=>$purchase->getProduct()->getName(),
                    ],
                "unit_amount"=>$purchase->getUnitPrice(),
                ],
                "quantity"=>$purchase->getQuantity(),

                ];
                 $lineItems [] = $item;
        }
        $successRoute = $this->generateUrl('stripe_valid_payment',[
            "locale"=>$request->getLocale(),
            "order"=>$order->getId(),
            "stripeSuccessKey"=>$order->getStripeSuccesKeys(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $cancelRoute = $this->generateUrl('stripe_cancel_payment',[
            "locale"=>$request->getLocale(),
            "order"=>$order->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);


        $stripeSession = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'payment_method_types'=>['card'],
            'success_url' => $successRoute . '/success.html',
            'cancel_url' => $cancelRoute . '/cancel.html',
                    ]);
        $order->setPiStripe($stripeSession->payment_intent);
        $em->flush($order);

        return $this->redirect($stripeSession->url,303);
    }
    #[Route('stripe/{order}/succes/{stripeSuccessKey}', name: 'stripe_valid_payment')]
    public function succes(Order $order, string $stripeSuccessKey): Response
    {
        dd($order);
          return $this->render('stripe/succes.html.twig');
    }
     #[Route('stripe/{order}/cancel', name: 'stripe_cancel_payment')]
    public function cancel(Order $order): Response
    {
        dd($order);
          return $this->render('stripe/cancel.html.twig');
    }
}
