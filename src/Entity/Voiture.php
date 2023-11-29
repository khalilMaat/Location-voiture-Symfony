<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?int $serie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_mise_circulation = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Location::class)]
    private Collection $Location;

    public function __construct()
    {
        $this->Location = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(int $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getDateMiseCirculation(): ?\DateTimeInterface
    {
        return $this->date_mise_circulation;
    }

    public function setDateMiseCirculation(\DateTimeInterface $date_mise_circulation): static
    {
        $this->date_mise_circulation = $date_mise_circulation;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocation(): Collection
    {
        return $this->Location;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->Location->contains($location)) {
            $this->Location->add($location);
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->Location->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }


}
