<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
#[ORM\Table(name: "Panier")]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_panier", type: "integer", nullable: false)]
    private $idPanier;

    #[ORM\Column(name: "id_enchere", type: "simple_array", nullable: false)]
    private $idEnchere = [];

    #[ORM\Column(name: "id_acteur", type: "integer", nullable: false)]
    private $idActeur;

    #[ORM\Column(name: "prixTotal", type: "float", precision: 10, scale: 0, nullable: false)]
    private $prixtotal;

    #[ORM\Column(name: "Date_Enchere", type: "date", nullable: false)]
    private $dateEnchere;

    

    // Getters and setters...

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getIdEnchere(): ?array
    {
        return $this->idEnchere;
    }

    public function setIdEnchere(array $idEnchere): self
    {
        $this->idEnchere = $idEnchere;
        return $this;
    }

    public function getIdActeur(): ?int
    {
        return $this->idActeur;
    }

    public function setIdActeur(int $idActeur): self
    {
        $this->idActeur = $idActeur;
        return $this;
    }

    public function getPrixtotal(): ?float
    {
        return $this->prixtotal;
    }

    public function setPrixtotal(float $prixtotal): self
    {
        $this->prixtotal = $prixtotal;
        return $this;
    }

    public function getDateEnchere(): ?\DateTimeInterface
    {
        return $this->dateEnchere;
    }

    public function setDateEnchere(\DateTimeInterface $dateEnchere): self
    {
        $this->dateEnchere = $dateEnchere;
        return $this;
    }
    public function calculateTotalAmount(): float
    {
        return $this->getPrixTotal();
    }

}
