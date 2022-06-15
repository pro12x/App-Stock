<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

//#[UniqueEntity("email")]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(["App\EntityListener\UserListener"])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email(message : " The email {{ value }} is not valid")]
    private $email;

    /* #[ORM\Column(type: 'json')]
    private $role = []; */

    #[ORM\Column(type: 'string')]
    #[Assert\EqualTo(propertyPath : "plainPassword")]
    private $password;

    #[Assert\EqualTo(propertyPath : "password", message : "Password is not valid !")]
    private string $plainPassword;

    #[ORM\ManyToMany(targetEntity: Roles::class, inversedBy: 'users')]
    private $roles;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    #[Assert\Length(min : 2, max : 50, minMessage : "Than less {{ limit }}", maxMessage : "gre{{ limit }}")]
    private $lastname;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    #[Assert\Length(
        min : 2,
        max : 50,
        minMessage : "",
        maxMessage : "")]
    private $firstname;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Product::class)]
    private $products;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        /* $roles = array(); //$this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles); */

        $roles = array();// $this->roles;

        /* foreach($this->groups as group)
        {

        } */

        if(!in_array(["ROLE_ADMIN"], $roles))
        {
            $roles[] = "ROLE_ADMIN";
        }

        return $roles;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword = "azertyuiop";
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        //$this->password = null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRole(Roles $role): self
    {
        /* if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        } */

        return $this;
    }

    public function removeRole(Roles $role): self
    {
        /* $this->roles->removeElement($role); */

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }
}
