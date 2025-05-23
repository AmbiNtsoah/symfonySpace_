<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Groups(['user:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Role>
     */
    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'users')]
    private Collection $roles;

    #[ORM\OneToOne(mappedBy: 'users', cascade: ['persist', 'remove'])]
    private ?Preference $preference = null;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): array
    {
        $roleNames = [];
        foreach ($this->roles as $role) {
            $roleNames[] = $role->getNom();
        }
        // Ajoute "ROLE_USER" par défaut pour éviter les problèmes de sécurité
        return array_unique(array_merge($roleNames, ['ROLE_USER']));
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRolesCollection(): Collection
    {
        return $this->roles;
    }
    // public function getRoles(): Collection
    // {
    //     return $this->roles;
    // }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setUsers($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUsers() === $this) {
                $role->setUsers(null);
            }
        }

        return $this;
    }

    public function getPreference(): ?Preference
    {
        return $this->preference;
    }

    public function setPreference(?Preference $preference): static
    {
        // unset the owning side of the relation if necessary
        if ($preference === null && $this->preference !== null) {
            $this->preference->setUsers(null);
        }

        // set the owning side of the relation if necessary
        if ($preference !== null && $preference->getUsers() !== $this) {
            $preference->setUsers($this);
        }

        $this->preference = $preference;

        return $this;
    }

     public function eraseCredentials(): void
    {
        // Permet d'effacer les données sensibles après l'authentification (si nécessaire)
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // Symfony utilise cette méthode pour identifier un utilisateur
    }
}
