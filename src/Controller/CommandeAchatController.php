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

    #[Route('/create', name: 'create_commande',methods: ['GET', 'POST'])]
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
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {

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


    #[Route('/read', name: 'liste_commande', methods: ['GET'])]
    public function read(CommandeAchatRepository $commandeAchatRepository): Response
    {   

        $listeDesCommandes=$commandeAchatRepository->findAll();
        return $this->render('commande_achat/listeCommande.html.twig', [
            'Commandes' => $listeDesCommandes,
        ]);
    }



    #[Route('/detail/{id}', name: 'detail_commande',methods: ['GET'])]
    public function detail(CommandeAchat $commandeAchat): Response
    {
        $tva=$commandeAchat->getTva();
        $t=$tva->getValeur();
        $articles=$commandeAchat->getArticles();
        $ligne=$commandeAchat->getLigneCommande();
        $somme=0;
        foreach ($ligne as $l) {
            $q=$l->getQuantite();
            $p=$l->getPrixUnitaire();
            $prixligne=$q * $p ;
            $somme += $prixligne;
        }
        
        
        
        $commandeAchat->setTotalHT($somme);
        $ttva=($somme*$t)/100;
        $commandeAchat->setTotalTVA($ttva);
        $totalttc=$somme+$ttva;
        $commandeAchat->setTotalTTC($totalttc);

        return $this->render('commande_achat/show.html.twig', [
            'commande' => $commandeAchat,
            'tva'=>$tva,
            'ligne'=>$ligne,
            'articles'=>$articles,
            'ttc'=>$totalttc,
            'ht'=>$somme,
        ]);
    }

    // #[Route('/pdf', name: 'pdf')]
    // public function downloadpdf(CommandeAchat $commandeAchat)
    // {   

    //     $dompdf = new Dompdf();

    //     $tva=$commandeAchat->getTva();
    //     $t=$tva->getValeur();
    //     $articles=$commandeAchat->getArticles();
    //     $ligne=$commandeAchat->getLigneCommande();
    //     $somme=0;
    //     foreach ($ligne as $l) {
    //         $q=$l->getQuantite();
    //         $p=$l->getPrixUnitaire();
    //         $prixligne=$q * $p ;
    //         $somme += $prixligne;
    //     }
        
        
        
    //     $commandeAchat->setTotalHT($somme);
    //     $ttva=($somme*$t)/100;
    //     $commandeAchat->setTotalTVA($ttva);
    //     $totalttc=$somme+$ttva;
    //     $commandeAchat->setTotalTTC($totalttc);

    //     $html=$this->render('commande_achat/show.html.twig', [
    //         'commande' => $commandeAchat,
    //         'tva'=>$tva,
    //         'ligne'=>$ligne,
    //         'articles'=>$articles,
    //         'ttc'=>$totalttc,
    //         'ht'=>$somme,
    //     ]);
    //     dd($html);

        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'portrait');
        // $dompdf->render();
        // $dompdf->stream("BonDeCommande.pdf", [
        //     "Attachment" => true
        // ]);

    // }

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


    #[Route('/delete/{id}', name: 'delete_commande')]
    public function delete(CommandeAchatRepository $commandeAchatRepository, CommandeAchat $commandeAchat, Request $request): Response
    {
    //    $this->denyAccessUnlessGranted('POST_DELETE', $commandeAchat);
        if ($this->isCsrfTokenValid('delete' . $commandeAchat->getId(), $request->request->get('_token'))) {
            $commandeAchatRepository->remove($commandeAchat, true);
        }

        return $this->redirectToRoute('liste_commande');
    }
    
}
