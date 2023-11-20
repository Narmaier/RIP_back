<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: StaffMember::class)]
    private Collection $staffMembers;

    public function __construct()
    {
        $this->staffMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, StaffMember>
     */
    public function getStaffMembers(): Collection
    {
        return $this->staffMembers;
    }

    public function addStaffMember(StaffMember $staffMember): static
    {
        if (!$this->staffMembers->contains($staffMember)) {
            $this->staffMembers->add($staffMember);
            $staffMember->setPost($this);
        }

        return $this;
    }

    public function removeStaffMember(StaffMember $staffMember): static
    {
        if ($this->staffMembers->removeElement($staffMember)) {
            // set the owning side to null (unless already changed)
            if ($staffMember->getPost() === $this) {
                $staffMember->setPost(null);
            }
        }

        return $this;
    }
}
