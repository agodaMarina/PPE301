<?php

namespace App\Entity;

use App\Repository\CommandeAchatRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: CommandeAchatRepository::class)]
class CommandeAchat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $NumeroCommande = null;

    #[ORM\Column]
    private ?float $TotalHT = 0;

    #[ORM\Column(nullable: false)]
    private ?float $TotalTVA = 0;

    #[ORM\Column]
    private ?float $TotalTTC = 0;

    #[ORM\Column(length: 255)]
    private ?string $MontantTotalEnLettre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ConditionDeReglement = null;

    #[ORM\Column]
    private ?bool $Statut = false;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'commandeAchats')]
    #[JoinTable(name:'LigneCommande')]
    private Collection $articles;

    #[ORM\ManyToOne(inversedBy: 'commandeAchats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tva $Tva = null;

   

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCommande = null;

    #[ORM\OneToMany(mappedBy: 'commandeAchat', targetEntity: LigneCommande::class , cascade:["persist"])]
    private Collection $ligneCommande;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->dateCommande= new \DateTimeImmutable();
        $this->ligneCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->NumeroCommande;
    }

    public function setNumeroCommande(int $NumeroCommande): static
    {
        $this->NumeroCommande = $NumeroCommande;

        return $this;
    }

   

    public function getTotalHT(): ?float
    {
        return $this->TotalHT;
    }

    public function setTotalHT(float $TotalHT): static
    {
        $this->TotalHT = $TotalHT;

        return $this;
    }

    public function getTotalTVA(): ?float
    {
        return $this->TotalTVA;
    }

    public function setTotalTVA(?float $TotalTVA): static
    {
        $this->TotalTVA = $TotalTVA;

        return $this;
    }

    public function getTotalTTC(): ?float
    {
        return $this->TotalTTC;
    }

    public function setTotalTTC(float $TotalTTC): static
    {
        $this->TotalTTC = $TotalTTC;

        return $this;
    }

    public function getMontantTotalEnLettre(): ?string
    {
        return $this->MontantTotalEnLettre;
    }

    public function setMontantTotalEnLettre(string $MontantTotalEnLettre): static
    {
        $this->MontantTotalEnLettre = $MontantTotalEnLettre;

        return $this;
    }

    public function getConditionDeReglement(): ?string
    {
        return $this->ConditionDeReglement;
    }

    public function setConditionDeReglement(string $ConditionDeReglement): static
    {
        $this->ConditionDeReglement = $ConditionDeReglement;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        $this->articles->removeElement($article);

        return $this;
    }

    public function getTva(): ?Tva
    {
        return $this->Tva;
    }

    public function setTva(?Tva $Tva): static
    {
        $this->Tva = $Tva;

        return $this;
    }


    public function getDateCommande(): ?\DateTimeImmutable
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeImmutable $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommande(): Collection
    {
        return $this->ligneCommande;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommande->contains($ligneCommande)) {
            $this->ligneCommande->add($ligneCommande);
            $ligneCommande->setCommandeAchat($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommande->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommandeAchat() === $this) {
                $ligneCommande->setCommandeAchat(null);
            }
        }

        return $this;
    }

  
    
}
