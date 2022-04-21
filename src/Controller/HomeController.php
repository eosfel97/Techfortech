<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\Mime\Email;
use App\Repository\ProductRepository;
use App\Repository\CategoryParentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    function index(ProductRepository $productRepository, CategoryParentRepository $categoryP, CartService $cartService): Response
    {
        $products = $productRepository->findAll();
        $products = $productRepository->findBy(
            [],
            [
                "name" => "ASC",
            ],
            4,
            0
        );
        $catep = $categoryP->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categoryps' => $catep,
            'itemspanier' => $cartService->getFullCart(),
        ]);
    }
    #[Route('/contact', name: 'home_contact')]
    function contact(Request $request, MailerInterface $mailer): Response
    {
        // $contact = new Contact();
        // $form = $this->createForm(ContactType::class, $contact);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $email = new TemplatedEmail();
        //     $email->to(new Address("contact@techfortech.net", "Any Gnahiet"))
        //         ->from($contact->getEmail())
        //         ->subject($contact->getSubject())
        //         ->htmlTemplate('email/contact.twig')
        //         ->context([
        //             "message" => $contact->getMessage(),
        //         ]);
        $email = new Email();
        $email->to("contact@techfortech.net")
            ->from("Bozo@gmail.com")
            ->subject("contatct")
            ->text("bonjours text");
        $mailer->send($email);
        $this->addFlash("success", "message good");
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);


        // return $this->renderForm('home/contact.twig', [
        //     'contact' => $contact,
        //     'form' => $form,
        // ]);
    }
}
