<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table]
class Task
{

    #[ORM\Column(type:"integer")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"AUTO")]
    private $id;

    #[ORM\Column(type:"datetime")]
    private $createdAt;

    #[ORM\Column(type:"string")]
    #[Assert\NotBlank(message:"Vous devez saisir un titre.")]
    private $title;

    #[ORM\Column(type:"text")]
    #[Assert\NotBlank(message:"Vous devez saisir du contenu.")]
    private $content;

    #[ORM\Column(type:"boolean")]
    private $isDone;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?User $author = null;


    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;

    }


    public function getId()
    {
        return $this->id;

    }


    public function getCreatedAt()
    {
        return $this->createdAt;

    }


    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

    }


    public function getTitle()
    {
        return $this->title;

    }


    public function setTitle($title)
    {
        $this->title = $title;

    }


    public function getContent()
    {
        return $this->content;

    }


    public function setContent($content)
    {
        $this->content = $content;

    }


    /**
     * Return the task state (done or to do)
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->isDone;

    }


    /**
     * Change the task state (done <--> to do)
     *
     * @param boolean $flag param
     *
     * @return void
     */
    public function toggle($flag)
    {
        $this->isDone = $flag;

    }


    public function getAuthor(): ?User
    {
        return $this->author;

    }


    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;

    }


}
