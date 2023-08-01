<?php

namespace App\Entity;

use App\Repository\TvaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TvaRepository::class)]
class Tva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $Statut = null;

    #[ORM\Column]
    private ?float $valeur = null;

    #[ORM\OneToMany(mappedBy: 'Tva', targetEntity: CommandeAchat::class)]
    private Collection $commandeAchats;

    public function __construct()
    {
        $this->commandeAchats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatut(): ?bool
    {
        return $this->Statut;
    }

    public function setStatut(bool $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
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
            $commandeAchat->setTva($this);
        }

        return $this;
    }

    public function removeCommandeAchat(CommandeAchat $commandeAchat): static
    {
        if ($this->commandeAchats->removeElement($commandeAchat)) {
            // set the owning side to null (unless already changed)
            if ($commandeAchat->getTva() === $this) {
                $commandeAchat->setTva(null);
            }
        }

        return $this;
    }
}
