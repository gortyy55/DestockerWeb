<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandRepository::class)]
#[ORM\Table(name: "demand")]
class Demand
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idDemand", type: "integer", nullable: false)]
    private $idDemand;

    #[ORM\Column(name: "description", type: "string", length: 1000, nullable: false)]
    private $description;

    // Getters and setters...

    public function getIdDemand(): ?int
    {
        return $this->idDemand;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}