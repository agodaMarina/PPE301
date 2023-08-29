<?php

namespace App\Entity;

use App\Repository\LigneCommandeAchatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneCommandeAchatRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ligneCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article;
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'ligneCommande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommandeAchat $commandeAchat;
 
    
    #[ORM\Column]
    private ?int $quantite = 0;

    #[ORM\Column]
    private ?float $prixUnitaire = 0;

    
    #[ORM\Column]
    private ?float $totalLigne;


   
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
    public function getTotalLigne(): ?int
    {
        return $this->totalLigne;
    }

    public function setTotalLigne(float $totalLigne): static
    {
        $this->totalLigne = $totalLigne;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getCommandeAchat(): ?CommandeAchat
    {
        return $this->commandeAchat;
    }

    public function setCommandeAchat(?CommandeAchat $commandeAchat): static
    {
        $this->commandeAchat = $commandeAchat;

        return $this;
    }
}
