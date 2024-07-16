<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Validator\Constraints as Assert;
use App\State\WaiterAssignmentProcessor;

#[ApiResource(
    forceEager: false,
    operations: [
        new GetCollection(security: "is_granted('ROLE_PATRON') || is_granted('ROLE_BARMAN') || is_granted('ROLE_WAITER')"),
        new Post(security: "is_granted('ROLE_BARMAN') || is_granted('ROLE_WAITER')", processor: WaiterAssignmentProcessor::class),
        new Get(security: "is_granted('ROLE_BARMAN') || is_granted('ROLE_WAITER')"),
        new Patch(
            security: "is_granted('ROLE_PATRON') || is_granted('ROLE_BARMAN') || is_granted('ROLE_WAITER') || is_granted('ROLE_USER')",
            denormalizationContext: ['groups' => ['patch']]
        ),
        new Delete(security: "is_granted('ROLE_PATRON')"),
    ],    
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read'])]
    private ?\DateTimeInterface $createdDate = null;

    /**
     * @var Collection<int, Drink>
     */
    #[ORM\ManyToMany(targetEntity: Drink::class, inversedBy: 'orders')]
    #[Groups(['read', 'write'])]
    private Collection $drinksList;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $tableNumber = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['read'])]
    private ?User $waiter = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['read', 'write'])]
    private ?User $barman = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write', 'patch'])]
    #[Assert\Choice(choices: ['en cours de préparation', 'prête', 'payée'], message: 'Invalid status.')]
    private ?string $status = null;

    public function __construct()
    {
        $this->drinksList = new ArrayCollection();
        $this->createdDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * @return Collection<int, Drink>
     */
    public function getDrinksList(): Collection
    {
        return $this->drinksList;
    }

    public function addDrinksList(Drink $drinksList): static
    {
        if (!$this->drinksList->contains($drinksList)) {
            $this->drinksList->add($drinksList);
        }

        return $this;
    }

    public function removeDrinksList(Drink $drinksList): static
    {
        $this->drinksList->removeElement($drinksList);

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(int $tableNumber): static
    {
        $this->tableNumber = $tableNumber;

        return $this;
    }

    public function getWaiter(): ?User
    {
        return $this->waiter;
    }

    public function setWaiter(?User $waiter): ?static
    {
        $this->waiter = $waiter;

        return $this;
    }

    public function getBarman(): ?User
    {
        return $this->barman;
    }

    public function setBarman(?User $barman): static
    {
        $this->barman = $barman;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
