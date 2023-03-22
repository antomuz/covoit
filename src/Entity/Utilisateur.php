<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
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
     * @ORM\Column(type="string", length=30)
     */
    private $telephone;

    /**
     * @ORM\Column(type="integer")
     */
    private $modeApp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\ManyToMany(targetEntity=Trajet::class, mappedBy="utilisateur_trajet")
     */
    private $trajetsParticiper;

    /**
     * @ORM\OneToMany(targetEntity=Trajet::class, mappedBy="idUtilisateurAuteur")
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

    /**
     * @ORM\Column(type="array")
     */
    private $role = [];

    public function __construct()
    {
        $this->trajetsParticiper = new ArrayCollection();
        $this->trajetsCreer = new ArrayCollection();
        $this->avisConcerner = new ArrayCollection();
        $this->avisDonner = new ArrayCollection();
        $this->commentaireDonner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setTelephone(string $telephone): self
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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

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
            $trajetsParticiper->addUtilisateurTrajet($this);
        }

        return $this;
    }

    public function removeTrajetsParticiper(Trajet $trajetsParticiper): self
    {
        if ($this->trajetsParticiper->removeElement($trajetsParticiper)) {
            $trajetsParticiper->removeUtilisateurTrajet($this);
        }

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
            $trajetsCreer->setIdUtilisateurAuteur($this);
        }

        return $this;
    }

    public function removeTrajetsCreer(Trajet $trajetsCreer): self
    {
        if ($this->trajetsCreer->removeElement($trajetsCreer)) {
            // set the owning side to null (unless already changed)
            if ($trajetsCreer->getIdUtilisateurAuteur() === $this) {
                $trajetsCreer->setIdUtilisateurAuteur(null);
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
            $avisConcerner->setIdUtilisateurConcerner($this);
        }

        return $this;
    }

    public function removeAvisConcerner(Avis $avisConcerner): self
    {
        if ($this->avisConcerner->removeElement($avisConcerner)) {
            // set the owning side to null (unless already changed)
            if ($avisConcerner->getIdUtilisateurConcerner() === $this) {
                $avisConcerner->setIdUtilisateurConcerner(null);
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
            $avisDonner->setIdUtilisateurAuteur($this);
        }

        return $this;
    }

    public function removeAvisDonner(Avis $avisDonner): self
    {
        if ($this->avisDonner->removeElement($avisDonner)) {
            // set the owning side to null (unless already changed)
            if ($avisDonner->getIdUtilisateurAuteur() === $this) {
                $avisDonner->setIdUtilisateurAuteur(null);
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
            $commentaireDonner->setIdUtilisateurAuteur($this);
        }

        return $this;
    }

    public function removeCommentaireDonner(Commentaire $commentaireDonner): self
    {
        if ($this->commentaireDonner->removeElement($commentaireDonner)) {
            // set the owning side to null (unless already changed)
            if ($commentaireDonner->getIdUtilisateurAuteur() === $this) {
                $commentaireDonner->setIdUtilisateurAuteur(null);
            }
        }

        return $this;
    }

    function __toString()
    {
        $identite=$this->getNom()." ".$this->getPrenom();
        return $identite;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }
}
