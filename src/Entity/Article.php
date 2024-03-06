<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    operations: [
    new Get(
    uriTemplate: '/articles/{id}',
    requirements: ['id' => '\d+'],
    normalizationContext: ['groups' => 'articles:item']),
    new GetCollection(
        uriTemplate: '/articles',
        normalizationContext: ['groups' => 'articles:list']),
    ],
    order: ['id' => 'ASC', 'title' => 'ASC'],
    paginationEnabled: true
   )]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api', 'admin', 'articles:item', 'articles:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['api', 'admin', 'articles:item', 'articles:list'])]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    #[Groups(['api', 'admin', 'articles:item', 'articles:list'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['api', 'admin', 'articles:item', 'articles:list'])]
    private ?\DateTimeInterface $createAt = null;

    #[ORM\ManyToOne]
    #[Groups(['api', 'admin'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[Groups(['api', 'admin'])]
    private Collection $categories;

    #[ORM\Column(length: 200)]
    #[Groups(['api', 'admin'])]
    private ?string $imgArticle = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getImgArticle(): ?string
    {
        return $this->imgArticle;
    }

    public function setImgArticle(string $imgArticle): static
    {
        $this->imgArticle = $imgArticle;

        return $this;
    }
}
