<?php

namespace App\Controller;

use App\Entity\CommandeAchat;
use App\Entity\LigneCommande;
use App\Form\CommandeAchatType;
use App\Repository\CommandeAchatRepository;
use App\Repository\LigneCommandeAchatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/CommandeAchat')]
class CommandeAchatController extends AbstractController
{

    #[Route('/create', name: 'create_commande')]
    public function create(Request $request, CommandeAchatRepository $commandeAchatRepository, LigneCommandeAchatRepository $ligneCommandeAchatRepository): Response
    {
        $commandeAchat = new commandeAchat();
        // $ligne = new LigneCommande();
        $formulaire = $this->createForm(CommandeAchatType::class, $commandeAchat);
        $formulaire->handleRequest($request);

        
        $numero= random_int(0, 9999);
        $commandeAchat->setNumeroCommande($numero);
        // $data=$request->get();
        $articles=$commandeAchat->getArticles();
        // $commandeAchat->setTotalHT($sommePrixArticle);
        $tva=$commandeAchat->getTva();
        $q= 1;
        $p=10;
        $totalht= $q* $p;
        if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

            $commandeAchatRepository->save($commandeAchat, true);
            $this->addFlash(
                'notice',
                'la commande a été créé avec succès !'
            );
            return $this->redirectToRoute('create_commande');
        }
        return $this->render('commande_achat/ajoutCommande.html.twig', [
            'formulaire' => $formulaire->createView(),
            'commande'=>$commandeAchat,
            'numero'=>$numero,
            'totalHt'=>$totalht,
            
            
        ]);
    }


    #[Route('/read', name: 'liste_commande')]
    public function read(CommandeAchatRepository $commandeAchatRepository): Response
    {   

        $listeDesCommandes=$commandeAchatRepository->findAll();
        return $this->render('commande_achat/listeCommande.html.twig', [
            'Commandes' => $listeDesCommandes,
        ]);
    }



    #[Route('/detail/{id}', name: 'detail_commande')]
    public function detail(CommandeAchat $commandeAchat): Response
    {
        $tva=$commandeAchat->getTva();
        $articles=$commandeAchat->getArticles();
        $ligne=$commandeAchat->getLigneCommande();
        return $this->render('commande_achat/show.html.twig', [
            'commande' => $commandeAchat,
            'tva'=>$tva,
            'ligne'=>$ligne,
            'articles'=>$articles
        ]);
    }


    // #[Route('/update/{id}', name: 'update_commande')]
    // public function update(): Response
    // {
    //    $formulaire= $this->createForm(FournisseurType::class, $fournisseur);
    //     $formulaire->handleRequest($request);

    //     if ($formulaire->isSubmitted() && $formulaire->isSubmitted()) {

    //         $fournisseurRepository->save($fournisseur, true);
    //         $this->addFlash(
    //             'notice : ',
    //             'le Fournisseur a été modifié avec succès !'
    //         );
    //         return $this->redirectToRoute('read_fournisseur');
    //     }
    //     return $this->render('fournisseur/modifierFournisseurs.html.twig', [
    //         'formulaire' => $formulaire->createView(),
    //         'fournisseur'=> $fournisseur
    //     ]);
    // }


    // #[Route('/delete/{id}', name: 'delete_commande')]
    // public function delete(): Response
    // {
    //     return $this->render('commande_achat/index.html.twig', [
    //         'controller_name' => 'CommandeAchatController',
    //     ]);
    // }
    
}
