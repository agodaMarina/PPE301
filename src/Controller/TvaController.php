<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TvaController extends AbstractController
{
    #[Route('/tva', name: 'app_tva')]
    public function index(): Response
    {
        return $this->render('tva/index.html.twig', [
            'controller_name' => 'TvaController',
        ]);
    }
}
