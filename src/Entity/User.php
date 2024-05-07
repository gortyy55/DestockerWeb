<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "User")]
#[ORM\Entity(repositoryClass: "App\Repository\UserRepository")]
#[ORM\UniqueConstraint(name: "user_email_unique", columns: ["email"])]
class User
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "email", type: "string", length: 255, nullable: false)]
    private $email;

    #[ORM\Column(name: "role", type: "string", length: 255, nullable: false, options: ["default" => "admin"])]
    private $role = 'admin';

    #[ORM\Column(name: "password", type: "string", length: 255, nullable: false)]
    private $password;

    #[ORM\Column(name: "firstname", type: "string", length: 255, nullable: false)]
    private $firstname;

    #[ORM\Column(name: "lastname", type: "string", length: 255, nullable: false)]
    private $lastname;

    #[ORM\Column(name: "address", type: "string", length: 255, nullable: false)]
    private $address;

    #[ORM\Column(name: "telephone", type: "integer", nullable: false)]
    private $telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
