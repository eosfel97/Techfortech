<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]

class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $Stripe_Succes_Keys;

  #[ORM\Column(type: 'boolean')]
  private $paid;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $piStripe;

  #[ORM\Column(type: 'integer')]
  private $totalPrice;

  #[ORM\Column(type: 'string', length: 255)]
  private $name;

  #[ORM\Column(type: 'string', length: 255)]
  private $firstname;

  #[ORM\Column(type: 'string', length: 255)]
  private $town;

  #[ORM\Column(type: 'string', length: 255)]
  private $country;

  #[ORM\Column(type: 'string', length: 255)]
  private $zip_code;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getStripeSuccesKeys(): ?string
    {
        return $this->Stripe_Succes_Keys;
    }

    public function setStripeSuccesKeys(?string $Stripe_Succes_Keys): self
    {
        $this->Stripe_Succes_Keys = $Stripe_Succes_Keys;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPiStripe(): ?string
    {
        return $this->piStripe;
    }

    public function setPiStripe(?string $piStripe): self
    {
        $this->piStripe = $piStripe;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

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

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

}
