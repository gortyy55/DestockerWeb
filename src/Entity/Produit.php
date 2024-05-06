<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "produit")]
#[ORM\Entity(repositoryClass: "App\Repository\ProduitRepository")]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private int $id;

    #[ORM\Column(name: "nom", type: "string", length: 255, nullable: false)]
    private string $nom;

    #[ORM\Column(name: "prix", type: "decimal", precision: 10, scale: 2, nullable: false)]
    private float $prix;

    #[ORM\Column(name: "prixActuel", type: "decimal", precision: 10, scale: 2, nullable: false)]
    private float $prixActuel;

    #[ORM\ManyToOne(targetEntity: Lot::class)]
    #[ORM\JoinColumn(name: "identifiant", referencedColumnName: "identifient")]
    private ?Lot $identifiant;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getPrixActuel(): ?float
    {
        return $this->prixActuel;
    }

    public function setPrixActuel(float $prixActuel): self
    {
        $this->prixActuel = $prixActuel;
        return $this;
    }

    public function getIdentifiant(): ?Lot
    {
        return $this->identifiant;
    }

    public function setIdentifiant(?Lot $identifiant): self
    {
        $this->identifiant = $identifiant;
        return $this;
    }
}
