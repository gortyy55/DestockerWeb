<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass=App\Repository\StockRepository::class)
 */
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private $id;

    #[ORM\Column(name: "produitname", type: "string", length: 255, nullable: false)]
    private $produitname;

    #[ORM\Column(name: "quantite", type: "integer", nullable: false)]
    private $quantite;

    #[ORM\Column(name: "mail", type: "string", length: 255, nullable: false)]
    private $mail;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "id_cat_id", referencedColumnName: "id")]
    private $idCat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduitname(): ?string
    {
        return $this->produitname;
    }

    public function setProduitname(string $produitname): self
    {
        $this->produitname = $produitname;
        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;
        return $this;
    }

    public function getIdCat(): ?Category
    {
        return $this->idCat;
    }

    public function setIdCat(?Category $idCat): self
    {
        $this->idCat = $idCat;
        return $this;
    }
}
