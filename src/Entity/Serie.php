<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
#[ApiResource]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resourceURI = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'series', targetEntity: Marvel::class)]
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
            $marvel->setSeries($this);
        }

        return $this;
    }

    public function removeMarvel(Marvel $marvel): self
    {
        if ($this->marvels->removeElement($marvel)) {
            // set the owning side to null (unless already changed)
            if ($marvel->getSeries() === $this) {
                $marvel->setSeries(null);
            }
        }

        return $this;
    }
}
