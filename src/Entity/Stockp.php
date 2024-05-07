<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stockp
 *
 * @ORM\Table(name="stockP", indexes={@ORM\Index(name="fk_stockP_category", columns={"id_cat"})})
 * @ORM\Entity(repositoryClass=App\Repository\StockpRepository::class)
 */
class Stockp
{
    /**
     * @var int
     *
     * @ORM\Column(name="idproduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="produitname", type="string", length=255, nullable=false)
     */
    private $produitname;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_cat", type="integer", nullable=true)
     */
    private $idCat;

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getProduitname(): ?string
    {
        return $this->produitname;
    }

    public function setProduitname(string $produitname): static
    {
        $this->produitname = $produitname;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getIdCat(): ?int
    {
        return $this->idCat;
    }

    public function setIdCat(?int $idCat): static
    {
        $this->idCat = $idCat;

        return $this;
    }


}
