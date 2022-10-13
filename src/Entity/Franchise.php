<?php

namespace App\Entity;

use App\Repository\FranchiseRepository;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: FranchiseRepository::class)]
class Franchise implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    private $passwordHasher;

    #[ORM\Column]
    private ?bool $is_activate = null;

    #[ORM\ManyToOne(inversedBy: 'franchises', targetEntity: User::class)]
    private $id_user;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Partner::class)]
    private Collection $partners;

    public function __construct(UserPasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->partners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $this->passwordHasher->hashPassword($this, $password);

        return $this;
    }

    public function isIsActivate(): ?bool
    {
        return $this->is_activate;
    }

    public function setIsActivate(bool $is_activate): self
    {
        $this->is_activate = $is_activate;

        return $this;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): self
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setFranchise($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): self
    {
        if ($this->partners->removeElement($partner)) {
            // set the owning side to null (unless already changed)
            if ($partner->getFranchise() === $this) {
                $partner->setFranchise(null);
            }
        }

        return $this;
    }
}
