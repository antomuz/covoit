<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
 */
class Avis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbEtoile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $corps;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="avisConcerner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUtilisateurConcerner;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="avisDonner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUtilisateurAuteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbEtoile(): ?int
    {
        return $this->nbEtoile;
    }

    public function setNbEtoile(int $nbEtoile): self
    {
        $this->nbEtoile = $nbEtoile;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(?string $corps): self
    {
        $this->corps = $corps;

        return $this;
    }

    public function getIdUtilisateurConcerner(): ?Utilisateur
    {
        return $this->idUtilisateurConcerner;
    }

    public function setIdUtilisateurConcerner(?Utilisateur $idUtilisateurConcerner): self
    {
        $this->idUtilisateurConcerner = $idUtilisateurConcerner;

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
}
