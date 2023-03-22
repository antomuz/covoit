<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(fields={"id"}, message="There is already an account with this id")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="integer")
     */
    private $modeApp;

    /**
     * @ORM\ManyToMany(targetEntity=Trajet::class)
     */
    private $trajetsParticiper;

    /**
     * @ORM\OneToMany(targetEntity=Trajet::class, mappedBy="idUtilisateurAuteur", mappedBy="utilisateur_trajet")
     */
    private $trajetsCreer;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="idUtilisateurConcerner")
     */
    private $avisConcerner;

    /**
     * @ORM\OneToMany(targetEntity=Avis::class, mappedBy="idUtilisateurAuteur")
     */
    private $avisDonner;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idUtilisateurAuteur")
     */
    private $commentaireDonner;

    public function __construct()
    {
        $this->trajetsParticiper = new ArrayCollection();
        $this->trajetsCreer = new ArrayCollection();
        $this->avisConcerner = new ArrayCollection();
        $this->avisDonner = new ArrayCollection();
        $this->commentaireDonner = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getModeApp(): ?int
    {
        return $this->modeApp;
    }

    public function setModeApp(int $modeApp): self
    {
        $this->modeApp = $modeApp;

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajetsParticiper(): Collection
    {
        return $this->trajetsParticiper;
    }

    public function addTrajetsParticiper(Trajet $trajetsParticiper): self
    {
        if (!$this->trajetsParticiper->contains($trajetsParticiper)) {
            $this->trajetsParticiper[] = $trajetsParticiper;
        }

        return $this;
    }

    public function removeTrajetsParticiper(Trajet $trajetsParticiper): self
    {
        $this->trajetsParticiper->removeElement($trajetsParticiper);

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajetsCreer(): Collection
    {
        return $this->trajetsCreer;
    }

    public function addTrajetsCreer(Trajet $trajetsCreer): self
    {
        if (!$this->trajetsCreer->contains($trajetsCreer)) {
            $this->trajetsCreer[] = $trajetsCreer;
            $trajetsCreer->setAvisConcerner($this);
        }

        return $this;
    }

    public function removeTrajetsCreer(Trajet $trajetsCreer): self
    {
        if ($this->trajetsCreer->removeElement($trajetsCreer)) {
            // set the owning side to null (unless already changed)
            if ($trajetsCreer->getAvisConcerner() === $this) {
                $trajetsCreer->setAvisConcerner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisConcerner(): Collection
    {
        return $this->avisConcerner;
    }

    public function addAvisConcerner(Avis $avisConcerner): self
    {
        if (!$this->avisConcerner->contains($avisConcerner)) {
            $this->avisConcerner[] = $avisConcerner;
            $avisConcerner->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvisConcerner(Avis $avisConcerner): self
    {
        if ($this->avisConcerner->removeElement($avisConcerner)) {
            // set the owning side to null (unless already changed)
            if ($avisConcerner->getUtilisateur() === $this) {
                $avisConcerner->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisDonner(): Collection
    {
        return $this->avisDonner;
    }

    public function addAvisDonner(Avis $avisDonner): self
    {
        if (!$this->avisDonner->contains($avisDonner)) {
            $this->avisDonner[] = $avisDonner;
            $avisDonner->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvisDonner(Avis $avisDonner): self
    {
        if ($this->avisDonner->removeElement($avisDonner)) {
            // set the owning side to null (unless already changed)
            if ($avisDonner->getUtilisateur() === $this) {
                $avisDonner->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaireDonner(): Collection
    {
        return $this->commentaireDonner;
    }

    public function addCommentaireDonner(Commentaire $commentaireDonner): self
    {
        if (!$this->commentaireDonner->contains($commentaireDonner)) {
            $this->commentaireDonner[] = $commentaireDonner;
            $commentaireDonner->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaireDonner(Commentaire $commentaireDonner): self
    {
        if ($this->commentaireDonner->removeElement($commentaireDonner)) {
            // set the owning side to null (unless already changed)
            if ($commentaireDonner->getUtilisateur() === $this) {
                $commentaireDonner->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function __ToString() : string
    {
        return $this->prenom." ".$this->nom;
    }
}
