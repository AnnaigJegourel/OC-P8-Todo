<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Table("user")]
#[ORM\Entity]
#[UniqueEntity("email")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Column(type: "integer")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 25, unique: true)]
    #[Assert\NotBlank(message: "Vous devez saisir un nom d'utilisateur.")]
    private $username;

    #[ORM\Column(type: "string", length: 64, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: "string", length: 60, unique: true)]
    #[Assert\NotBlank(message: "Vous devez saisir une adresse email.")]
    #[Assert\Email(message: "Le format de l'adresse n'est pas correcte.")]
    private $email;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\Column(type: 'json')]
    private array $roles;


    public function __construct()
    {
        $this->tasks = new ArrayCollection();

    }


    public function getId()
    {
        return $this->id;

    }


    public function getUsername(): string
    {
        return $this->username;

    }


    public function setUsername($username)
    {
        $this->username = $username;

    }


    public function getSalt(): ?string
    {
        return null;

    }


    /**
     * @see PasswordAuthenticatedUserInterface
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;

    }


    public function setPassword($password)
    {
        $this->password = $password;

    }


    public function getEmail()
    {
        return $this->email;

    }


    public function setEmail($email)
    {
        $this->email = $email;

    }


    public function eraseCredentials()
    {

    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;

    }


    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;

    }


    public function addTask(Task $task): self
    {
        if ($this->tasks->contains($task) === false) {
            $this->tasks->add($task);
            $task->setAuthor($this);
        }

        return $this;

    }


    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task) === true) {

            // Set the owning side to null (unless already changed).
            if ($task->getAuthor() === $this) {
                $task->setAuthor(null);
            }
        }

        return $this;

    }


    /**
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Guarantee every user at least has ROLE_USER.
        $roles[] = 'ROLE_USER';

        return array_unique($roles);

    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;

    }


}
