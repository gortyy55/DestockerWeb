<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LotRepository::class)]
#[ORM\Table(name: "lot")]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "identifient", type: "integer", nullable: false)]
    private $identifient;

    #[ORM\Column(name: "idenchere", type: "integer", nullable: false)]
    private $idenchere;

    #[ORM\Column(name: "idproduit", type: "integer", nullable: false)]
    private $idproduit;

    #[ORM\Column(name: "idlot", type: "integer", nullable: false)]
    private $idlot;

    public function getIdentifient(): ?int
    {
        return $this->identifient;
    }

    public function getIdenchere(): ?int
    {
        return $this->idenchere;
    }

    public function setIdenchere(int $idenchere): self
    {
        $this->idenchere = $idenchere;
        return $this;
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function setIdproduit(int $idproduit): self
    {
        $this->idproduit = $idproduit;
        return $this;
    }

    public function getIdlot(): ?int
    {
        return $this->idlot;
    }

    public function setIdlot(int $idlot): self
    {
        $this->idlot = $idlot;
        return $this;
    }
}
