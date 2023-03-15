<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource]
class Event
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

    #[ORM\ManyToMany(targetEntity: Marvel::class, mappedBy: 'events')]
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
            $marvel->addEvent($this);
        }

        return $this;
    }

    public function removeMarvel(Marvel $marvel): self
    {
        if ($this->marvels->removeElement($marvel)) {
            $marvel->removeEvent($this);
        }

        return $this;
    }
}
