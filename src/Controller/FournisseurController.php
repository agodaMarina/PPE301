<?php

namespace App\Controller;

use App\Repository\FournisseurRepository;
use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fournisseur')]
class FournisseurController extends AbstractController
{
    #[Route('/create', name: 'create_fournisseur')]
    public function create(FournisseurRepository $fournisseurRepository, Request $request): Response
    {
        
        $fournisseur= new Fournisseur();
        $formulaire= $this->createForm(FournisseurType::class, $fournisseur);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $fournisseurRepository->save($fournisseur, true);
            $this->addFlash(
                'notice : ',
                'le Fournisseur a été créé avec succès !'
            );
            return $this->redirectToRoute('create_fournisseur');
        }
        return $this->render('fournisseur/ajoutFournisseurs.html.twig', [
            'formulaire' => $formulaire->createView(),
        ]);
    }
    #[Route('/read', name: 'read_fournisseur')]
    public function read(FournisseurRepository $fournisseurRepository): Response
    {

        $listefournisseur= $fournisseurRepository->findAll();
        return $this->render('fournisseur/listeFournisseurs.html.twig', [
            'listefournisseur' => $listefournisseur,
        ]);
    }

    #[Route('/detail/{id}', name: 'detail_fournisseur')]
    public function show(Fournisseur $fournisseur): Response
    {

        
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/update/{id}', name: 'update_fournisseur')]
    public function update(Fournisseur $fournisseur, Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        
        $formulaire= $this->createForm(FournisseurType::class, $fournisseur);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $fournisseurRepository->save($fournisseur, true);
            $this->addFlash(
                'notice : ',
                'le Fournisseur a été modifié avec succès !'
            );
            return $this->redirectToRoute('read_fournisseur');
        }
        return $this->render('fournisseur/modifierFournisseurs.html.twig', [
            'formulaire' => $formulaire->createView(),
            'fournisseur'=> $fournisseur
        ]);
    }


    #[Route('/delete/{id}', name: 'delete_fournisseur')]
    public function delete(Fournisseur $fournisseur, Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(),$request->request->get('_token'))) {
            $fournisseurRepository->remove($fournisseur, true);
        }

        return $this->redirectToRoute('read_fournisseur');
    }
}
