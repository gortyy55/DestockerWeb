<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Category $id_cat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"The product name cannot be blank.")]
    private ?string $produitname = null;

    #[ORM\Column]
    #[Assert\NotNull(message:"The quantity cannot be null.")]
    #[Assert\Type(type:"integer", message:"The quantity must be an integer.")]
    #[Assert\PositiveOrZero(message:"The quantity must be a positive number.")]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"The email cannot be blank.")]
    #[Assert\Email(message:"Please enter a valid email address.")]
    private ?string $mail = null;
    #[ORM\Column(type: 'float')]
    private $averageRating = 0;
    #[ORM\OneToMany(mappedBy: 'stock', targetEntity: Rating::class)]
    private Collection $ratings;

    public function __construct() {
        $this->ratings = new ArrayCollection();
    }
    public function getAverageRating(): float
    {
        return $this->averageRating;
    }

    public function setAverageRating(float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getRatings(): Collection
    {
        return $this->ratings;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCat(): ?Category
    {
        return $this->id_cat;
    }

    public function setIdCat(?Category $id_cat): self
    {
        $this->id_cat = $id_cat;

        return $this;
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
    public function updateAverageRating(): void
{
    $totalRating = 0;
    $numRatings = 0;

    foreach ($this->ratings as $rating) {
        $totalRating += $rating->getRating();
        $numRatings++;
    }

    $this->averageRating = $numRatings > 0 ? $totalRating / $numRatings : 0;
}
}
