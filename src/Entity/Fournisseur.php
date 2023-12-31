<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $nomFournisseur = null;

    #[ORM\Column(length: 255)]
    private ?string $contactFournisseur = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseFournisseur = null;

    #[ORM\Column(length: 255)]
    private ?string $emailFournisseur = null;

   
  

    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'fournisseurs')]
    private Collection $articles;

    public function __construct()
    {
       
       
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->nomFournisseur;
    }

    public function setNomFournisseur(string $nomFournisseur): static
    {
        $this->nomFournisseur = $nomFournisseur;

        return $this;
    }

    public function getContactFournisseur(): ?string
    {
        return $this->contactFournisseur;
    }

    public function setContactFournisseur(string $contactFournisseur): static
    {
        $this->contactFournisseur = $contactFournisseur;

        return $this;
    }

    public function getAdresseFournisseur(): ?string
    {
        return $this->adresseFournisseur;
    }

    public function setAdresseFournisseur(string $adresseFournisseur): static
    {
        $this->adresseFournisseur = $adresseFournisseur;

        return $this;
    }

    public function getEmailFournisseur(): ?string
    {
        return $this->emailFournisseur;
    }

    public function setEmailFournisseur(string $emailFournisseur): static
    {
        $this->emailFournisseur = $emailFournisseur;

        return $this;
    }

    


    
public function __toString()
{
    return $this->nomFournisseur;
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
        $article->addFournisseur($this);
    }

    return $this;
}

public function removeArticle(Article $article): static
{
    if ($this->articles->removeElement($article)) {
        $article->removeFournisseur($this);
    }

    return $this;
}
    
}
