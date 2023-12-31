<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = 0;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quantiteAlerte = 5;

    
    #[ORM\OneToOne(mappedBy: 'stock', cascade: ['persist', 'remove'])]
    private ?Article $article = null;

    // #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    // private ?\DateTimeImmutable $date = null;

   public function __construct()
   {
    // $this->date = new \DateTimeImmutable();
    
   }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantiteAlerte(): ?int
    {
        return $this->quantiteAlerte;
    }

    public function setQuantiteAlerte(int $quantiteAlerte): static
    {
        $this->quantiteAlerte = $quantiteAlerte;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        // unset the owning side of the relation if necessary
        if ($article === null && $this->article !== null) {
            $this->article->setStock(null);
        }

        // set the owning side of the relation if necessary
        if ($article !== null && $article->getStock() !== $this) {
            $article->setStock($this);
        }

        $this->article = $article;

        return $this;
    }

    // public function getDate(): ?\DateTimeImmutable
    // {
    //     return $this->date;
    // }

    // public function setDate(\DateTimeImmutable $date): static
    // {
    //     $this->date = $date;

    //     return $this;
    // }

    
}
