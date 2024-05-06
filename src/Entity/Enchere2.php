<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\Enchere2Repository; // Import EnchereRepository class

#[ORM\Entity(repositoryClass: Enchere2Repository::class)] // Use EnchereRepository without the App\Entity namespace
#[ORM\Table(name: "enchere")]
class Enchere2
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private int $id;

    #[ORM\Column(name: "nom", type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(name: "dateduree", type: "datetime")]
    private \DateTimeInterface $dateduree;

    public function __construct()
    {
        $this->dateduree = new \DateTime();
    }

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

    public function getDateduree(): ?\DateTimeInterface
    {
        return $this->dateduree;
    }

    public function setDateduree(?\DateTimeInterface $dateduree): self
    {
        $this->dateduree = $dateduree;
        return $this;
    }
}
