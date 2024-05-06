<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LotRepository; // Import LotRepository class

#[ORM\Entity(repositoryClass: LotRepository::class)] // Use LotRepository without the App\Entity namespace
#[ORM\Table(name: "lot")]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "identifient", type: "integer", nullable: false)]
    private int $identifient;

    #[ORM\Column(name: "datede_creation", type: "datetime")]
    private \DateTimeInterface $datedeCreation;

    #[ORM\Column(name: "idenchere", type: "integer", nullable: false)]
    private int $idenchere;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: "lot")]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->datedeCreation = new \DateTime();
    }

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

    public function getDatedeCreation(): \DateTimeInterface
    {
        return $this->datedeCreation;
    }

    public function setDatedeCreation(\DateTimeInterface $datedeCreation): self
    {
        $this->datedeCreation = $datedeCreation;
        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setLot($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getLot() === $this) {
                $produit->setLot(null);
            }
        }

        return $this;
    }
}
