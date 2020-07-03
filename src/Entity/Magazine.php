<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MagazineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"magazine:read"}},
 *     denormalizationContext={"groups"={"magazine:write"}}
 * )
 * @ORM\Entity(repositoryClass=MagazineRepository::class)
 */
class Magazine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("magazine:read")
     */
    private ?int $id;

    /**
     * @Groups("magazine:read")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @Groups("magazine:read")
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="magazine")
     * @var Collection|Category[]
     */
    private Collection $categories;

    public function __construct()
    {
        $this->id=null;
        $this->name=null;
        $this->categories = new ArrayCollection();
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

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setMagazine($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getMagazine() === $this) {
                $category->setMagazine(null);
            }
        }

        return $this;
    }
}
