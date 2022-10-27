<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('franchise:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('franchise:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 5)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    private $passwordHasher;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Franchise $franchise = null;

    #[ORM\Column]
    private ?bool $is_activate = null;

    #[ORM\ManyToMany(targetEntity: ModuleStructure::class, mappedBy: 'partner')]
    private Collection $moduleStructures;

    public function __construct(UserPasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->partners = new ArrayCollection();
        $this->moduleStructures = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

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

    /**
     * @return Collection<int, ModuleStructure>
     */
    public function getModuleStructures(): Collection
    {
        return $this->moduleStructures;
    }

    public function addModuleStructure(ModuleStructure $moduleStructure): self
    {
        if (!$this->moduleStructures->contains($moduleStructure)) {
            $this->moduleStructures->add($moduleStructure);
            $moduleStructure->addPartner($this);
        }

        return $this;
    }

    public function removeModuleStructure(ModuleStructure $moduleStructure): self
    {
        if ($this->moduleStructures->removeElement($moduleStructure)) {
            $moduleStructure->removePartner($this);
        }

        return $this;
    }
}
