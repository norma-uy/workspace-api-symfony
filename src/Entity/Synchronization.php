<?php

namespace App\Entity;

use App\Repository\SynchronizationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SynchronizationRepository::class)]
class Synchronization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\Column(type: 'string', length: 125)]
    private $synchronizedEntity;

    #[ORM\Column(type: 'json', nullable: true)]
    private $synchronizedData = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getSynchronizedEntity(): ?string
    {
        return $this->synchronizedEntity;
    }

    public function setSynchronizedEntity(string $synchronizedEntity): self
    {
        $this->synchronizedEntity = $synchronizedEntity;

        return $this;
    }

    public function getSynchronizedData(): ?array
    {
        return $this->synchronizedData;
    }

    public function setSynchronizedData(?array $synchronizedData): self
    {
        $this->synchronizedData = $synchronizedData;

        return $this;
    }
}
