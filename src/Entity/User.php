<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
    new Get(
    uriTemplate: '/utilisateur/{id}',
    requirements: ['id' => '\d+'],
    normalizationContext: ['groups' => 'utilisateur:item']),
    new GetCollection(
        uriTemplate: '/utilisateur',
        normalizationContext: ['groups' => 'utilisateur:list']),
    ],
    order: ['id' => 'ASC', 'name' => 'ASC'],
    paginationEnabled: true
   )]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api', 'admin', 'utilisateur:item', 'utilisateur:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'admin', 'utilisateur:item', 'utilisateur:list'])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['api', 'admin', 'utilisateur:item', 'utilisateur:list'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Groups(['api', 'admin'])]
    private ?string $mail = null;

    #[ORM\Column(length: 100)]
    #[Groups(['api', 'admin'])]
    private ?string $pssword = null;

    #[ORM\Column(length: 200)]
    #[Groups(['api', 'admin', 'utilisateur:item', 'utilisateur:list'])]
    private ?string $img = null;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPssword(): ?string
    {
        return $this->pssword;
    }

    public function setPssword(string $pssword): static
    {
        $this->pssword = $pssword;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }
    public function __toString() : string 
    {
        return $this->firstName . " " . $this->name;
    }
}
