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
    #[ORM\Column(name: "id_dons", type: "integer", nullable: false)]
    private $idDons;

    #[ORM\Column(type: "string", length: 30, nullable: false)]
    private $association;

    #[ORM\Column(type: "string", length: 50, nullable: false)]
    private $title;

    #[ORM\Column(type: "string", length: 200, nullable: false)]
    private $description;

    public function getIdDons(): ?int
    {
        return $this->idDons;
    }

    public function getAssociation(): ?string
    {
        return $this->association;
    }

    public function setAssociation(string $association): self
    {
        $this->association = $association;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
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
