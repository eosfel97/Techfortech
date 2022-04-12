<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: CategoryParent::class, inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $file;



    public function __construct()
    {
        $this->categoryParents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getCategory(): ?CategoryParent
    {
        return $this->category;
    }

    public function setCategory(?CategoryParent $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }
}
