<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[route("/article")]
class ArticleController extends AbstractController
{
    #[Route('/create', name: 'create_article',methods: ['GET', 'POST'])]
  
    public function create(ArticleRepository $articleRepository, Request $request): Response
    {

        $article = new Article();
        $formulaire = $this->createForm(ArticleType::class, $article);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $articleRepository->save($article, true);
            $this->addFlash(
                'notice',
                'nouvel article créé avec succès !'
            );
            return $this->redirectToRoute('create_article');
        }
        return $this->render('article/ajoutProduits.html.twig', [
            'formulaire' => $formulaire->createView(),
        ]);
    }

    #[Route('/read', name: 'liste_article',methods: ['GET'])]
    public function read(ArticleRepository $articleRepository): Response
    {
        $listeArticle = $articleRepository->findAll();
        return $this->render('article/listeProduits.html.twig', [
            'articles' => $listeArticle,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_article',methods: ['GET'])]
    public function show(Article $article): Response
    {
        $fournisseurs=$article->getFournisseurs();
        $q=$article->getStock();
        $qa=$q->getQuantite();
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'fournisseurs'=>$fournisseurs,
            'quantiteEnStock'=>$qa,

        ]);
    }


    #[Route('/update/{id}', name: 'update_article',methods: ['GET', 'POST'])]
    
    public function update(ArticleRepository $articleRepository, Article $article, Request $request): Response
    {
        $formulaire = $this->createForm(ArticleType::class, $article);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {

            $articleRepository->save($article, true);
            $this->addFlash(
                'notice',
                'l\'article a été modifié avec succès !'
            );
            return $this->redirectToRoute('liste_article');
        }
         $this->denyAccessUnlessGranted('POST_VIEW', $article);
        return $this->render('article/modifierProduits.html.twig', [
            'formulaire' => $formulaire->createView(),
            'article'=>$article
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_article',methods: ['POST'])]
  
    public function delete(ArticleRepository $articleRepository, Article $article, Request $request): Response
    {
       $this->denyAccessUnlessGranted('POST_DELETE', $article);
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('liste_article');
    }
}
