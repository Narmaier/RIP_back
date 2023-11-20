<?php

namespace App\Entity;

use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BranchRepository::class)]
class Branch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'branches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $state = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 512)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $phone_number = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Auto::class)]
    private Collection $autos;

    #[ORM\OneToMany(mappedBy: 'branch', targetEntity: StaffMember::class)]
    private Collection $staff;

    public function __construct()
    {
        $this->autos = new ArrayCollection();
        $this->staff = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @return Collection<int, Auto>
     */
    public function getAutos(): Collection
    {
        return $this->autos;
    }

    public function addAuto(Auto $auto): static
    {
        if (!$this->autos->contains($auto)) {
            $this->autos->add($auto);
            $auto->setLocation($this);
        }

        return $this;
    }

    public function removeAuto(Auto $auto): static
    {
        if ($this->autos->removeElement($auto)) {
            // set the owning side to null (unless already changed)
            if ($auto->getLocation() === $this) {
                $auto->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StaffMember>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(StaffMember $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
            $staff->setBranch($this);
        }

        return $this;
    }

    public function removeStaff(StaffMember $staff): static
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getBranch() === $this) {
                $staff->setBranch(null);
            }
        }

        return $this;
    }
}
