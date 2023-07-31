<?php

namespace App\Entity;

use App\Repository\CommandeAchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeAchatRepository::class)]
class CommandeAchat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumeroCommande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column]
    private ?float $TotalHT = null;

    #[ORM\Column(nullable: false)]
    private ?float $TotalTVA = null;

    #[ORM\Column]
    private ?float $TotalTTC = null;

    #[ORM\Column(length: 255)]
    private ?string $MontantTotalEnLettre = null;

    #[ORM\Column(length: 255)]
    private ?string $ConditionDeReglement = null;

    #[ORM\Column()]
    private ?bool $Statut = null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

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
}