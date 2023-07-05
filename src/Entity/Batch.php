<?php

namespace App\Entity;

use App\Repository\BatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BatchRepository::class)
 */
class Batch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $priceKilo;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilos;

    /**
     * @ORM\OneToMany(targetEntity=OrderLine::class, mappedBy="batch")
     */
    private $orderLines;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPriceKilo(): ?float
    {
        return $this->priceKilo;
    }

    public function setPriceKilo(float $priceKilo): self
    {
        $this->priceKilo = $priceKilo;

        return $this;
    }

    public function getKilos(): ?int
    {
        return $this->kilos;
    }

    public function setKilos(int $kilos): self
    {
        $this->kilos = $kilos;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): self
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
            $orderLine->setBatch($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): self
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getBatch() === $this) {
                $orderLine->setBatch(null);
            }
        }

        return $this;
    }
}
