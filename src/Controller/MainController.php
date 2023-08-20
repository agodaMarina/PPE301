<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ArticleRepository $articleRepository): Response
    {
        if ($this->getUser()) {
            return $this->render('main/template.html.twig', [
                'controller_name' => 'MainController',
                'nombreArticle'=>$articleRepository->getNombre(),
                'coutTotal'=>$articleRepository->getPrixTotal(),
                'top'=>$articleRepository->getPrixEleve(),
            ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }
    }
}
