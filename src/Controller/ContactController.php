<?php

namespace App\Controller;


use DateTime;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(CartService $cartService, Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $date = new DateTimeImmutable();
            $contact->setCreatedAt($date);

            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', "Votre produit a été ajouter au panier");
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'items' => $cartService->getFullCart(),
            'form' => $form->createView(),
        ]);
    }
}
