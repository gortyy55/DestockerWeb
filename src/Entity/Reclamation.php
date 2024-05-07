<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: "Reclamation")]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_reclamation", type: "integer", nullable: false)]
    private $idReclamation;

    #[ORM\Column(name: "titre", type: "string", length: 35, nullable: false)]
    private $titre;

    #[ORM\Column(name: "type", type: "string", length: 35, nullable: false)]
    private $type;

    #[ORM\Column(name: "id_produit", type: "integer", nullable: false)]
    private $idProduit;

    #[ORM\Column(name: "Description", type: "string", length: 200, nullable: false)]
    private $description;

    #[ORM\Column(name: "id_user", type: "integer", nullable: false)]
    private $idUser;

    #[ORM\Column(name: "cheminFichierJoint", type: "text", length: 65535, nullable: true)]
    private $cheminfichierjoint;

    #[ORM\Column(name: "statut", type: "string", length: 255, nullable: true, options: ["default" => "En attente"])]
    private $statut = 'En attente';

    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function setIdProduit(int $idProduit): self
    {
        $this->idProduit = $idProduit;
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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getCheminfichierjoint(): ?string
    {
        return $this->cheminfichierjoint;
    }

    public function setCheminfichierjoint(?string $cheminfichierjoint): self
    {
        $this->cheminfichierjoint = $cheminfichierjoint;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }
}
