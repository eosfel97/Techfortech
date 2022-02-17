<?php

namespace App\Controller;

use App\Form\Builder\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'home')]
function index(): Response
    {
    return $this->render('home/index.html.twig', [
        'controller_name' => 'HomeController',
        'nom' => 'Gnahiet any',
    ]);
}
#[Route('/contact', name:'home_contact')]
function contact(Request $request, MailerInterface $mailer): Response
    {
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $email = new TemplatedEmail();
        $email->to(new Address("contact@techfortech.net", "Any Gnahiet"))
            ->from($contact->getEmail())
            ->subject($contact->getSubject())
            ->htmlTemplate('email/contact.twig')
            ->context([
                "message" => $contact->getMessage(),
            ]);

        $mailer->send($email);
        $this->addFlash("success", "message good");
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('home/contact.twig', [
        'contact' => $contact,
        'form' => $form,
    ]);
}
}
