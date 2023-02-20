<?php

namespace App\Entity;

use App\Repository\RecordRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: RecordRepository::class)]
class Record
{
    public const DATE_FORMAT = 'd-m-Y H:i:s';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $startDate = null;

    #[ORM\Column(type: 'integer')]
    protected ?int $price = null;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'records')]
    #[ORM\JoinColumn(name: 'client_id', nullable: true, onDelete: 'CASCADE')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTime $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}