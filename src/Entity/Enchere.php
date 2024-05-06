<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnchereRepository::class)]
#[ORM\Table(name: "Enchere")]
class Enchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer", nullable: false)]
    private $id;

    #[ORM\Column(type: "integer", nullable: false)]
    private $stock;

    #[ORM\Column(type: "text", length: 65535, nullable: false)]
    private $produit;

    #[ORM\Column(type: "float", precision: 10, scale: 0, nullable: false)]
    private $prixinit;

    #[ORM\Column(name: "idAchteur", type: "text", length: 65535, nullable: false)]
    private $idAchteur;

    #[ORM\Column(type: "float", precision: 10, scale: 0, nullable: false)]
    private $prixactuel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;
        return $this;
    }

    public function getPrixinit(): ?float
    {
        return $this->prixinit;
    }

    public function setPrixinit(float $prixinit): self
    {
        $this->prixinit = $prixinit;
        return $this;
    }

    public function getIdAchteur(): ?string
    {
        return $this->idAchteur;
    }

    public function setIdAchteur(string $idAchteur): self
    {
        $this->idAchteur = $idAchteur;
        return $this;
    }

    public function getPrixactuel(): ?float
    {
        return $this->prixactuel;
    }

    public function setPrixactuel(float $prixactuel): self
    {
        $this->prixactuel = $prixactuel;
        return $this;
    }
}
