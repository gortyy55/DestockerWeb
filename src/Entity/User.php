<?php
 
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: "User")]
#[ORM\Entity(repositoryClass: "App\Repository\UserRepository")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id;
 
    #[ORM\Column(name: "email", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;
 
    #[ORM\Column(name: "role", type: "string", length: 255, nullable: false, options: ["default" => "admin"])]
    private string $role = 'client';
 
    #[ORM\Column(name: "password", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)] // Exemple de vérification de longueur minimale du mot de passe
    private string $password;
 
    #[ORM\Column(name: "firstname", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank]
    private string $firstname;
 
    #[ORM\Column(name: "lastname", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank]
    private string $lastname;
 
    #[ORM\Column(name: "address", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank]
    private string $address;
 
    #[ORM\Column(name: "telephone", type: "integer", nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type("integer")]
    #[Assert\Length(8)]
    private int $telephone;
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getEmail(): ?string
    {
        return $this->email;
    }
 
    public function setEmail(string $email): static
    {
        $this->email = $email;
 
        return $this;
    }
 
    public function getRole(): ?string
    {
        return $this->role;
    }
 
    public function setRole(string $role): static
    {
        $this->role = $role;
 
        return $this;
    }
 
    public function getPassword(): ?string
    {
        return $this->password;
    }
 
    public function setPassword(string $password): static
    {
        $this->password = $password;
 
        return $this;
    }
 
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
 
    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
 
        return $this;
    }
 
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
 
    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
 
        return $this;
    }
 
    public function getAddress(): ?string
    {
        return $this->address;
    }
 
    public function setAddress(string $address): static
    {
        $this->address = $address;
 
        return $this;
    }
 
    public function getTelephone(): ?int
    {
        return $this->telephone;
    }
 
    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;
 
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $role = $this->role;
        
        $roles = 'ROLE_'.strtoupper($role);

        return [$roles];
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        return null;
    }
    public function getSalt(){
  return null;
    }

    public function getUserName(){
        return $this->email;
    }

}
 