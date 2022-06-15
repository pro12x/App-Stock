<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/add', name: 'product_add')]
    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface, Product $product): Response
    {
        if(!$product)
        {
            $product = new Product();
        }

        $form = $this->createForm(Product::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("product_list");
        }

        return $this->render('product/add.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    #[Route("/product/list", name : "product_list")]
    public function list(ManagerRegistry $sql): Response
    {
        $product = $sql->getRepository(Product::class);
        $product = $product->findAll();

        return $this->render("product/list.html.twig", ["product" => $product]);
    }
}
