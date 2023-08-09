<?php

namespace App\Controller;

use App\Entity\CommandeAchat;
use App\Form\CommandeAchatType;
use App\Repository\CommandeAchatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/CommandeAchat')]
class CommandeAchatController extends AbstractController
{

    #[Route('/create', name: 'create_commande')]
    public function create(Request $request, CommandeAchatRepository $commandeAchatRepository): Response
    {
        $commandeAchat = new commandeAchat();
        $formulaire = $this->createForm(CommandeAchatType::class, $commandeAchat);
        $formulaire->handleRequest($request);

        $sommePrixArticle=0;
        $articles=$commandeAchat->getArticles();
        foreach ($articles as  $article) {
            
            $sommePrixArticle +=$article->getPrixArticle();
        }
        $commandeAchat->setTotalHT($sommePrixArticle);
        $tva=$commandeAchat->getTva();
        $prixht=$commandeAchat->getTotalHT();
        $totaltva= $tva.$prixht;
        $commandeAchat->setTotalTVA($totaltva);
        $totalttc=$totaltva+$prixht;
        $commandeAchat->setTotalTTC($totalttc);

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
            'totaltva'=>$totaltva,
            'totalttc'=>$totalttc,
            'prixht'=>$prixht,
            
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
        //statut de la commande a affiché
        $fournisseur=$commandeAchat->getFournisseur();
        $articles=$commandeAchat->getArticles();
        return $this->render('commande_achat/show.html.twig', [
            'commande' => $commandeAchat,
            'fournisseur'=>$fournisseur,
            'articles'=>$articles,
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
