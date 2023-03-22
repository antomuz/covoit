<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
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
    private $villeDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeArrivee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $voiture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="trajetsParticiper")
     */
    private $utilisateur_trajet;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="trajetsCreer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $idUtilisateurAuteur;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idTrajetConcerner")
     */
    private $commentaireTrajet;

    public function __construct()
    {
        $this->utilisateur_trajet = new ArrayCollection();
        $this->commentaireTrajet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getVoiture(): ?string
    {
        return $this->voiture;
    }

    public function setVoiture(string $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurTrajet(): Collection
    {
        return $this->utilisateur_trajet;
    }

    public function addUtilisateurTrajet(Utilisateur $utilisateurTrajet): self
    {
        if (!$this->utilisateur_trajet->contains($utilisateurTrajet)) {
            $this->utilisateur_trajet[] = $utilisateurTrajet;
        }

        return $this;
    }

    public function removeUtilisateurTrajet(Utilisateur $utilisateurTrajet): self
    {
        $this->utilisateur_trajet->removeElement($utilisateurTrajet);

        return $this;
    }

    public function getIdUtilisateurAuteur(): ?Utilisateur
    {
        return $this->idUtilisateurAuteur;
    }

    public function setIdUtilisateurAuteur(?Utilisateur $idUtilisateurAuteur): self
    {
        $this->idUtilisateurAuteur = $idUtilisateurAuteur;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaireTrajet(): Collection
    {
        return $this->commentaireTrajet;
    }

    public function addCommentaireTrajet(Commentaire $commentaireTrajet): self
    {
        if (!$this->commentaireTrajet->contains($commentaireTrajet)) {
            $this->commentaireTrajet[] = $commentaireTrajet;
            $commentaireTrajet->setIdTrajetConcerner($this);
        }

        return $this;
    }

    public function removeCommentaireTrajet(Commentaire $commentaireTrajet): self
    {
        if ($this->commentaireTrajet->removeElement($commentaireTrajet)) {
            // set the owning side to null (unless already changed)
            if ($commentaireTrajet->getIdTrajetConcerner() === $this) {
                $commentaireTrajet->setIdTrajetConcerner(null);
            }
        }

        return $this;
    }

    public function __ToString() : string
    {
        return $this->getVilleDepart()." - ".$this->getVilleArrivee();
    }


}
