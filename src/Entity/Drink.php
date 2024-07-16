<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new GetCollection(security: "is_granted('ROLE_BARMAN')"),
        new Post(security: "is_granted('ROLE_BARMAN')"),
        new Get(security: "is_granted('ROLE_BARMAN')"),
        new Patch(security: "is_granted('ROLE_BARMAN')"),
        new Delete(security: "is_granted('ROLE_BARMAN')"),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    forceEager: false,
)]

#[UniqueEntity('name')]
#[ORM\Entity(repositoryClass: DrinkRepository::class)]
class Drink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?float $price = null;

    #[ORM\OneToOne(inversedBy: 'drink', cascade: ['persist', 'remove'])]
    #[Groups(['read', 'write'])]
    private ?Media $file = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'drinksList')]
    #[Groups(['read', 'write'])]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFile(): ?Media
    {
        return $this->file;
    }

    public function setFile(?Media $file): static
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addDrinksList($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeDrinksList($this);
        }

        return $this;
    }
}
