<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/add', name: 'category_add')]
    #[Route('/category/edit/{id}', name: 'category_edit')]
    public function add(Request $request, EntityManagerInterface $entityManagerInterface, Category $category = null): Response
    {
        if(!$category)
        {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("category_list");
        }

        return $this->render('category/add.html.twig', [
            'categoryForm' => $form->createView(), "isExist" => $category->getId() !== null
        ]);
    }

    #[Route("category/list", name: "category_list")]
    public function list(ManagerRegistry $sql) : Response
    {
        $category = $sql->getRepository(Category::class);
        $category = $category->findAll();

        return $this->render("category/list.html.twig", ["category" => $category]);
    }
}
