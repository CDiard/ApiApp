<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StorieRepository::class)]
#[ApiResource]
class Storie
{
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resourceURI = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Marvel::class, mappedBy: 'stories')]
    private Collection $marvels;


    public function __construct()
    {
        $this->marvels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResourceURI(): ?string
    {
        return $this->resourceURI;
    }

    public function setResourceURI(?string $resourceURI): self
    {
        $this->resourceURI = $resourceURI;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Marvel>
     */
    public function getMarvels(): Collection
    {
        return $this->marvels;
    }

    public function addMarvel(Marvel $marvel): self
    {
        if (!$this->marvels->contains($marvel)) {
            $this->marvels->add($marvel);
            $marvel->addStory($this);
        }

        return $this;
    }

    public function removeMarvel(Marvel $marvel): self
    {
        if ($this->marvels->removeElement($marvel)) {
            $marvel->removeStory($this);
        }

        return $this;
    }
}
