<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
    new Get(
    uriTemplate: '/category/{id}',
    requirements: ['id' => '\d+'],
    normalizationContext: ['groups' => 'category:item']),
    new GetCollection(
        uriTemplate: '/category',
        normalizationContext: ['groups' => 'category:list']),
    ],        
    order: ['id' => 'ASC', 'name' => 'ASC'],
    paginationEnabled: true
   )]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    #[Groups(['api', 'admin', 'category:item', 'category:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'admin', 'category:item', 'category:list'])]
    private ?string $name = null;

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
    public function __toString() : string 
    {
        return $this->name;
    }
}
