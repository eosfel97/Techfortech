<?php

namespace App\Controller;

use App\Entity\Product;
use App\Data\SearchData;
use App\Entity\Comments;
use App\Form\SearchForm;
use App\Form\ProductType;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/all/{page}', name: 'product_index', methods: ['GET'], defaults: ["page" => 1], requirements: ["page" => "\d+"])]
    public function index(ProductRepository $productRepository, Request $request): Response
    {

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $formsearch = $this->createForm(SearchForm::class, $data);
        $formsearch->handleRequest($request);
        $products = $productRepository->findSearch($data);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $formsearch->createView(),
        ]);
    }

    // #[Route('/new', name: 'product_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $product = new Product();
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($product);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('product/new.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'product_show', methods: ['GET', 'POST'])]
    public function show(Product $product, Request $request, EntityManagerInterface $em, CommentsRepository $cem): Response
    {
        $comments = $cem->findComments($product);
        $user = $this->getUser();

        $comment = new Comments;
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                $this->addFlash('danger', "Vous devez creer un compte pour laisser un commentaire");
                return $this->redirectToRoute('app_login');
            }
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setProducts($product);
            $comment->setUser($user);
            $comment->setName($user->getLastname());
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire a bien été envoyé, il sera valide après vérification.');
            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'comments' => $comments
        ]);
    }

    // #[Route('/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('product/edit.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'product_delete', methods: ['POST'])]
    // public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($product);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    // }
}
