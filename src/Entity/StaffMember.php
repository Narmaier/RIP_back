<?php

namespace App\Entity;

use App\Repository\StaffMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffMemberRepository::class)]
class StaffMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'staffMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $middle_name = null;

    #[ORM\ManyToOne(inversedBy: 'staff')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Branch $branch = null;

    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Order::class)]
    private Collection $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(string $middle_name): static
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Order $sale): static
    {
        if (!$this->sales->contains($sale)) {
            $this->sales->add($sale);
            $sale->setSeller($this);
        }

        return $this;
    }

    public function removeSale(Order $sale): static
    {
        if ($this->sales->removeElement($sale)) {
            // set the owning side to null (unless already changed)
            if ($sale->getSeller() === $this) {
                $sale->setSeller(null);
            }
        }

        return $this;
    }
}
