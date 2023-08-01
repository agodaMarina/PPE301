<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeAchatController extends AbstractController
{
    #[Route('/commande/achat', name: 'app_commande_achat')]
    public function index(): Response
    {
        return $this->render('commande_achat/index.html.twig', [
            'controller_name' => 'CommandeAchatController',
        ]);
    }
}
