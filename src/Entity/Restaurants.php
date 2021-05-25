<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=App\Repository\RestaurantsRepository::class)
 * @Vich\Uploadable
 */
class Restaurants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $phone;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $average_note;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $picture;

    /**
	 * @Vich\UploadableField(mapping="restaurants_pictures", fileNameProperty="picture")
	 */
	private $pictureFile;

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="restaurant")
     * @ORM\OrderBy({"updatedAt" = "DESC"})
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=Cities::class, inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"list_restaurants", "list_markers"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isApproved;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="restaurants")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="restaurants")
     */
    private $user_creation;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="restaurant")
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity=ModificationSuggestion::class, mappedBy="restaurant")
     */
    private $modificationSuggestions;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->modificationSuggestions = new ArrayCollection();
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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(?bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function setPictureFile(?File $pictureFile = null): self
    {
        $this->pictureFile = $pictureFile;

		if($this->pictureFile instanceof UploadedFile)
		{
			$this->uploadedAt = new \DateTime('now');
		}

		return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addRestaurant($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeRestaurant($this);
        }

        return $this;
    }

    public function getUserCreation(): ?Users
    {
        return $this->user_creation;
    }

    public function setUserCreation(?Users $user_creation): self
    {
        $this->user_creation = $user_creation;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setRestaurant($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getRestaurant() === $this) {
                $picture->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ModificationSuggestion[]
     */
    public function getModificationSuggestions(): Collection
    {
        return $this->modificationSuggestions;
    }

    public function addModificationSuggestion(ModificationSuggestion $modificationSuggestion): self
    {
        if (!$this->modificationSuggestions->contains($modificationSuggestion)) {
            $this->modificationSuggestions[] = $modificationSuggestion;
            $modificationSuggestion->setRestaurant($this);
        }

        return $this;
    }

    public function removeModificationSuggestion(ModificationSuggestion $modificationSuggestion): self
    {
        if ($this->modificationSuggestions->removeElement($modificationSuggestion)) {
            // set the owning side to null (unless already changed)
            if ($modificationSuggestion->getRestaurant() === $this) {
                $modificationSuggestion->setRestaurant(null);
            }
        }

        return $this;
    }
}
