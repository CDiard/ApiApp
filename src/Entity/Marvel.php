<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\MarvelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MarvelRepository::class)]
#[ApiResource(operations: [
        new Get(),
        new Post(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationItemsPerPage: 30,
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'name' => 'partial', 'modified' => 'exact'])]
class Marvel
{
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(['read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $modified = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[Groups(['read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resourceURI = null;

    #[Groups(['read'])]
    #[ORM\ManyToMany(targetEntity: Comic::class, inversedBy: 'marvels')]
    private Collection $comics;

    #[Groups(['read'])]
    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'marvels')]
    private Collection $series;

    #[Groups(['read'])]
    #[ORM\ManyToMany(targetEntity: Storie::class, inversedBy: 'marvels')]
    private Collection $stories;

    #[Groups(['read'])]
    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'marvels')]
    private Collection $events;

    public function __construct()
    {
        $this->comics = new ArrayCollection();
        $this->series = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
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

    /**
     * @return Collection<int, Comic>
     */
    public function getComics(): Collection
    {
        return $this->comics;
    }

    public function addComic(Comic $comic): self
    {
        if (!$this->comics->contains($comic)) {
            $this->comics->add($comic);
        }

        return $this;
    }

    public function removeComic(Comic $comic): self
    {
        $this->comics->removeElement($comic);

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Serie $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series->add($series);
        }

        return $this;
    }

    public function removeSeries(Serie $series): self
    {
        $this->series->removeElement($series);

        return $this;
    }

    /**
     * @return Collection<int, Storie>
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Storie $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories->add($story);
        }

        return $this;
    }

    public function removeStory(Storie $story): self
    {
        $this->stories->removeElement($story);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }
}
