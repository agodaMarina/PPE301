<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/create', name: 'create_categorie')]
    public function create(CategorieRepository $categorieRepository, Request $request): Response
    {
        $categorie= new Categorie();
        $formulaire= $this->createForm(CategorieType::class, $categorie);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $categorieRepository->save($categorie, true);
            $this->addFlash(
                'notice : ',
                'la catégorie a été créée avec succès !'
            );
            return $this->redirectToRoute('create_categorie');
        }
        return $this->render('categorie/ajoutCategories.html.twig', [
            'formulaire' => $formulaire,
        ]);
    }

    #[Route('/read', name: 'liste_categorie')]
    public function read(CategorieRepository $categorieRepository): Response
    {
        $liste_categorie=$categorieRepository->findAll();
        return $this->render('categorie/listeCategories.html.twig', [
            'categories' => $liste_categorie,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_categorie')]
    public function show(Categorie $categorie): Response
    {   
        
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/update/{id}', name: 'update_categorie')]
    public function update(CategorieRepository $categorieRepository, Categorie $categorie, Request $request): Response
    {
        $formulaire= $this->createForm(CategorieType::class, $categorie);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $categorieRepository->save($categorie, true);
            $this->addFlash(
                'notice : ',
                'la catégorie a été modifiée avec succès !'
            );
            return $this->redirectToRoute('liste_categorie');
        }
        return $this->render('categorie/modifierCategories.html.twig', [
            'formulaire' => $formulaire->createView(),
            'categorie'=> $categorie
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_categorie')]
    public function delete(Categorie $categorie, Request $request, CategorieRepository $categorieRepository): Response
    {
        if($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))){
            $categorieRepository->remove($categorie, true);
        }
        return $this->redirectToRoute('liste_categorie',[], Response::HTTP_SEE_OTHER);
    }
}
