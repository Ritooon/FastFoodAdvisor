<?php

namespace App\Entity;

use App\Repository\RestaurantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RestaurantsRepository::class)
 */
class Restaurants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_restaurants"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_restaurants"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_restaurants"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"list_restaurants"})
     */
    private $phone;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"list_restaurants"})
     */
    private $average_note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants"})
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="restaurant")
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=Cities::class, inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAverageNote(): ?float
    {
        return $this->average_note;
    }

    public function setAverageNote(?float $average_note): self
    {
        $this->average_note = $average_note;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Notes[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setRestaurant($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getRestaurant() === $this) {
                $note->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }
}
