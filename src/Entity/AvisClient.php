<?php

namespace App\Entity;

use App\Repository\AvisClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisClientRepository::class)]
#[ORM\Table(name: "Avis_Client")]
class AvisClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer", nullable: false)]
    private $idAvis;

    #[ORM\Column(type: "boolean", nullable: true)]
    private $satisfaction;

    #[ORM\Column(type: "text", length: 65535, nullable: true)]
    private $comment;

    #[ORM\ManyToOne(targetEntity: Reclamation::class)]
    #[ORM\JoinColumn(name: "id_reclamation", referencedColumnName: "id_reclamation")]
    private $idReclamation;

    public function getIdAvis(): ?int
    {
        return $this->idAvis;
    }

    public function isSatisfaction(): ?bool
    {
        return $this->satisfaction;
    }

    public function setSatisfaction(?bool $satisfaction): self
    {
        $this->satisfaction = $satisfaction;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getIdReclamation(): ?Reclamation
    {
        return $this->idReclamation;
    }

    public function setIdReclamation(?Reclamation $idReclamation): self
    {
        $this->idReclamation = $idReclamation;
        return $this;
    }
}
