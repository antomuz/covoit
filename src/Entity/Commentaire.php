<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $corps;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commentaireDonner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUtilisateurAuteur;

    /**
     * @ORM\ManyToOne(targetEntity=Trajet::class, inversedBy="commentaireTrajet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idTrajetConcerner;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(string $corps): self
    {
        $this->corps = $corps;

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

    public function getIdTrajetConcerner(): ?Trajet
    {
        return $this->idTrajetConcerner;
    }

    public function setIdTrajetConcerner(?Trajet $idTrajetConcerner): self
    {
        $this->idTrajetConcerner = $idTrajetConcerner;

        return $this;
    }
}
