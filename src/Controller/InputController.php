<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InputController extends AbstractController
{
    #[Route('/input', name: 'app_input')]
    public function index(): Response
    {
        return $this->render('input/index.html.twig', [
            'controller_name' => 'InputController',
        ]);
    }
}
