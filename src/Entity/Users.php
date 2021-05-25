<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"username"}, message="Aïe Aïe Aïe, ce pseudo est visiblement déjà utilisé")
 * @UniqueEntity(fields={"email"}, message="Seriez-vous par hasard déjà inscrit ?")
 */
class Users implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas")
     */
    private $passwordVerification;

    /**
     * @ORM\OneToMany(targetEntity=Notes::class, mappedBy="user")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=Restaurants::class, mappedBy="user_creation")
     */
    private $restaurants;

    /**
     * @ORM\OneToMany(targetEntity=ModificationSuggestion::class, mappedBy="user")
     */
    private $modificationSuggestions;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
        $this->modificationSuggestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordVerification(): ?string
    {
        return $this->passwordVerification;
    }

    public function setPasswordVerification(string $passwordVerification): self
    {
        $this->passwordVerification = $passwordVerification;

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
            $note->setUser($this);
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {

        $roles = $this->roles;

        if(gettype($roles) == 'string') {
            $roles = explode(',', $roles);
        }

        return $roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        
    }

    public function eraseCredentials()
    {
        
    }

    /**
     * @return Collection|Restaurants[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurants $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setUserCreation($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurants $restaurant): self
    {
        if ($this->restaurants->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getUserCreation() === $this) {
                $restaurant->setUserCreation(null);
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
            $modificationSuggestion->setUser($this);
        }

        return $this;
    }

    public function removeModificationSuggestion(ModificationSuggestion $modificationSuggestion): self
    {
        if ($this->modificationSuggestions->removeElement($modificationSuggestion)) {
            // set the owning side to null (unless already changed)
            if ($modificationSuggestion->getUser() === $this) {
                $modificationSuggestion->setUser(null);
            }
        }

        return $this;
    }
}
