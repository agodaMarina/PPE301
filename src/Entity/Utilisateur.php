<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte enregistré avec ce Email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    #[ORM\Column(length: 200)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180)]
    private ?string $contact = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    // #[ORM\Column(length: 100)]
    // private ?string $resetToken;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $genre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function getContact(): ?string
    {
        return $this->contact;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }
    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
    // public function getResetToken(): ?string
    // {
    //     return $this->resetToken;
    // }

    // public function setResetToken(?string $resetToken): self
    // {
    //     $this->resetToken = $resetToken;

    //     return $this;
    // }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isGenre(): ?bool
    {
        return $this->genre;
    }

    public function setGenre(bool $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
}
