<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\component\HttpFoundation\File\UploadedFile;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping as ORM;
//use Vich\UploaderBundle\Entity\File;
use Symfony\component\HttpFoundation\File\File;
#[ORM\Entity(repositoryClass: ArticleRepository::class)]

#[Vich\Uploadable]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomArticle = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prixArticle = null;

   
    #[Vich\UploadableField(mapping: 'articles', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

 

    #[ORM\ManyToMany(targetEntity: CommandeAchat::class, mappedBy: 'articles')]
    private Collection $commandeAchats;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, inversedBy: 'articles')]
    #[ORM\JoinTable(name:"ligneArticle")]
    private Collection $fournisseurs;

    #[ORM\OneToOne(inversedBy: 'article', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: LigneCommande::class)]
    private Collection $ligneCommandes;


    public function __construct()
    {
        
        $this->commandeAchats = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->stock = new Stock();
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): static
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prixArticle;
    }

    public function setPrixArticle(float $prixArticle): static
    {
        $this->prixArticle = $prixArticle;

        return $this;
    }

   

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            //$this->updatedAt = new \DateTimeImmutable();
        }
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

   


    public function __toString()
    {
        return $this->nomArticle;
    }

   

    /**
     * @return Collection<int, CommandeAchat>
     */
    public function getCommandeAchats(): Collection
    {
        return $this->commandeAchats;
    }

    public function addCommandeAchat(CommandeAchat $commandeAchat): static
    {
        if (!$this->commandeAchats->contains($commandeAchat)) {
            $this->commandeAchats->add($commandeAchat);
            $commandeAchat->addArticle($this);
        }

        return $this;
    }

    public function removeCommandeAchat(CommandeAchat $commandeAchat): static
    {
        if ($this->commandeAchats->removeElement($commandeAchat)) {
            $commandeAchat->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): static
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): static
    {
        $this->fournisseurs->removeElement($fournisseur);

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): static
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->add($ligneCommande);
            $ligneCommande->setArticle($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): static
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getArticle() === $this) {
                $ligneCommande->setArticle(null);
            }
        }

        return $this;
    }
    
}
