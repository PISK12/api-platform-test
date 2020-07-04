<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"category:read"}},
 *     denormalizationContext={"groups"={"category:write"}}
 * )
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
	/**
	 * @Groups({"magazine:read","category:read","post:read"})
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;

	/**
	 * @Groups({"magazine:read","category:read","post:read"})
	 * @ORM\Column(type="string", length=255)
	 */
	private ?string $name;

	/**
	 * @Groups({"magazine:read","category:read","post:read"})
	 * @ORM\ManyToOne(targetEntity=Magazine::class, inversedBy="categories")
	 */
	private ?Magazine $magazine;

	/**
	 * @Groups({"magazine:read","category:read"})
	 * @ORM\OneToMany(targetEntity=Post::class, mappedBy="category", orphanRemoval=true)
	 * @var Collection | Post[]
	 */
	private Collection $posts;

	public function __construct()
	{
		$this->id = null;
		$this->name = null;
		$this->magazine = null;
		$this->posts = new ArrayCollection();
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

	public function getMagazine(): ?Magazine
	{
		return $this->magazine;
	}

	public function setMagazine(?Magazine $magazine): self
	{
		$this->magazine = $magazine;

		return $this;
	}

	/**
	 * @return Collection|Post[]
	 */
	public function getPosts(): Collection
	{
		return $this->posts;
	}

	public function addPost(Post $post): self
	{
		if (!$this->posts->contains($post)) {
			$this->posts[] = $post;
			$post->setCategory($this);
		}

		return $this;
	}

	public function removePost(Post $post): self
	{
		if ($this->posts->contains($post)) {
			$this->posts->removeElement($post);
			// set the owning side to null (unless already changed)
			if ($post->getCategory() === $this) {
				$post->setCategory(null);
			}
		}

		return $this;
	}
}
