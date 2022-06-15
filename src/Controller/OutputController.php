<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutputController extends AbstractController
{
    #[Route('/output', name: 'app_output')]
    public function index(): Response
    {
        return $this->render('output/index.html.twig', [
            'controller_name' => 'OutputController',
        ]);
    }
}
