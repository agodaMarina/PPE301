<?php

namespace App\Controller;

use App\Entity\Tva;
use App\Form\TvaType;
use App\Repository\TvaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Tva')]
class TvaController extends AbstractController
{
    #[Route('/read', name: 'liste_tva',methods: ['GET'])]
    public function index(TvaRepository $tvaRepository): Response
    {
        $tva= $tvaRepository->findAll();
        return $this->render('tva/listeTva.html.twig', [
            'tvas' => $tva,
        ]);
    }
    #[Route('/create', name: 'create_tva',methods: ['GET', 'POST'])]
    public function create(TvaRepository $tvaRepository, Request $request): Response
    {
        $tva=new Tva();
        $formulaire=$this->createForm(TvaType::class, $tva);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $tvaRepository->save($tva, true);
            $this->addFlash(
                'notice',
                'nouvelle Tva créée avec succès !'
            );
            return $this->redirectToRoute('create_tva');
        }
        return $this->render('tva/AjouterTva.html.twig', [
            'formulaire' => $formulaire->createView(),
        ]);
    }
    #[Route('/update/{id}', name: 'update_tva',methods: ['GET', 'POST'])]
    public function update(TvaRepository $tvaRepository, Tva $tva, Request $request): Response
    {
        $formulaire=$this->createForm(TvaType::class, $tva);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $tvaRepository->save($tva, true);
            $this->addFlash(
                'notice',
                ' Tva modifiée avec succès !'
            );
            return $this->redirectToRoute('liste_tva');
        }
        return $this->render('tva/ModifierTva.html.twig', [
            'formulaire' => $formulaire->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'delete_tva')]
    public function delete(Tva $Tva, Request $request, TvaRepository $TvaRepository): Response
    {
        
        $TvaRepository->remove($Tva, true);
        $this->addFlash(
            'notice',
            ' Tva supprimée avec succès !'
        );
       

        return $this->redirectToRoute('liste_tva');
    }
}
