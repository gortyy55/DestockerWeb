<?php

namespace App\Entity;

use App\Repository\DonsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonsRepository::class)]
#[ORM\Table(name: "Dons")]
class Dons
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idDons", type: "integer", nullable: false)]
    private $idDons;

    #[ORM\Column(name: "amount", type: "integer", nullable: false)]
    private $amount;

    #[ORM\ManyToOne(targetEntity: Demand::class)]
    #[ORM\JoinColumn(name: "idDemand", referencedColumnName: "idDemand")]
    private $idDemand;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user", referencedColumnName: "id")]
    private $user;

    // Getters and setters...

    public function getIdDons(): ?int
    {
        return $this->idDons;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getIdDemand(): ?Demand
    {
        return $this->idDemand;
    }

    public function setIdDemand(?Demand $idDemand): self
    {
        $this->idDemand = $idDemand;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}