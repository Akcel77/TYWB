<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departPlace;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrivalPlace;

    /**
     * @ORM\OneToMany(targetEntity=Ride::class, mappedBy="category")
     */
    private $rides;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $road;

    public function __construct()
    {
        $this->rides = new ArrayCollection();
    }

    public function __toString(){
        return $this->getRoad();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartPlace(): ?string
    {
        return $this->departPlace;
    }

    public function setDepartPlace(string $departPlace): self
    {
        $this->departPlace = $departPlace;

        return $this;
    }

    public function getArrivalPlace(): ?string
    {
        return $this->arrivalPlace;
    }

    public function setArrivalPlace(string $arrivalPlace): self
    {
        $this->arrivalPlace = $arrivalPlace;

        return $this;
    }

    /**
     * @return Collection<int, Ride>
     */
    public function getRides(): Collection
    {
        return $this->rides;
    }

    public function addRide(Ride $ride): self
    {
        if (!$this->rides->contains($ride)) {
            $this->rides[] = $ride;
            $ride->setCategory($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->removeElement($ride)) {
            // set the owning side to null (unless already changed)
            if ($ride->getCategory() === $this) {
                $ride->setCategory(null);
            }
        }

        return $this;
    }

    public function getRoad(): ?string
    {
        return $this->road;
    }

    public function setRoad(string $road): self
    {
        $this->road = $road;

        return $this;
    }
}
