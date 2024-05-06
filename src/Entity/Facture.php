<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
#[ORM\Table(name: "Facture")]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_facture", type: "integer", nullable: false)]
    private $idFacture;

    #[ORM\Column(name: "id_acteur", type: "integer", nullable: false)]
    private $idActeur;

    #[ORM\Column(name: "id_panier", type: "integer", nullable: false)]
    private $idPanier;

    #[ORM\Column(name: "name_card", type: "string", length: 100, nullable: false)]
    private $nameCard;

    #[ORM\Column(name: "ccn", type: "integer", nullable: false)]
    private $ccn;

    #[ORM\Column(name: "exp_date", type: "date", nullable: false)]
    private $expDate;

    #[ORM\Column(name: "security_code", type: "integer", nullable: false)]
    private $securityCode;

    #[ORM\Column(name: "adrress", type: "string", length: 100, nullable: false)]
    private $adrress;

    #[ORM\Column(name: "city", type: "string", length: 100, nullable: false)]
    private $city;

    #[ORM\Column(name: "state", type: "string", length: 100, nullable: false)]
    private $state;

    #[ORM\Column(name: "zip_code", type: "integer", nullable: false)]
    private $zipCode;

    #[ORM\Column(name: "country", type: "string", length: 100, nullable: false)]
    private $country;

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getIdActeur(): ?int
    {
        return $this->idActeur;
    }

    public function setIdActeur(int $idActeur): self
    {
        $this->idActeur = $idActeur;
        return $this;
    }

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function setIdPanier(int $idPanier): self
    {
        $this->idPanier = $idPanier;
        return $this;
    }

    public function getNameCard(): ?string
    {
        return $this->nameCard;
    }

    public function setNameCard(string $nameCard): self
    {
        $this->nameCard = $nameCard;
        return $this;
    }

    public function getCcn(): ?int
    {
        return $this->ccn;
    }

    public function setCcn(int $ccn): self
    {
        $this->ccn = $ccn;
        return $this;
    }

    public function getExpDate(): ?\DateTimeInterface
    {
        return $this->expDate;
    }

    public function setExpDate(\DateTimeInterface $expDate): self
    {
        $this->expDate = $expDate;
        return $this;
    }

    public function getSecurityCode(): ?int
    {
        return $this->securityCode;
    }

    public function setSecurityCode(int $securityCode): self
    {
        $this->securityCode = $securityCode;
        return $this;
    }

    public function getAdrress(): ?string
    {
        return $this->adrress;
    }

    public function setAdrress(string $adrress): self
    {
        $this->adrress = $adrress;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }
}
