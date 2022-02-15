<?php

namespace App\Entity;

use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM; 
use App\Repository\ProductRepository;

#[ORM\Entity(repositoryClass:ProductRepository::class)]
class Product
{
    #[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type:'integer')]
private $id;

#[ORM\Column(type:'string', length:255)]
private $name;

#[ORM\Column(type:'string', length:255, nullable:true)]
private $description;

#[ORM\Column(type:'integer')]
private $price;

#[ORM\Column(type:'integer', nullable:true)]
private $reduct;

#[ORM\ManyToOne(targetEntity:Category::class)]
private $category_id;

public function getId(): ?int
    {
    return $this->id;
}

function getName(): ?string
    {
    return $this->name;
}

function setName(string $name): self
    {
    $this->name = $name;

    return $this;
}

function getDescription(): ?string
    {
    return $this->description;
}

function setDescription(?string $description): self
    {
    $this->description = $description;

    return $this;
}

function getPrice(): ?int
    {
    return $this->price;
}

function setPrice(int $price): self
    {
    $this->price = $price;

    return $this;
}

function getReduct(): ?int
    {
    return $this->reduct;
}

function setReduct(?int $reduct): self
    {
    $this->reduct = $reduct;

    return $this;
}

function getCategoryId(): ?Category
    {
    return $this->category_id;
}

function setCategoryId(?Category $category_id): self
    {
    $this->category_id = $category_id;

    return $this;
}
}
