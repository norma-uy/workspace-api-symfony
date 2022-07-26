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
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\Column(type: 'string', length: 125)]
    private $synchronized_entity;

    #[ORM\Column(type: 'json', nullable: true)]
    private $synchronized_data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

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
        return $this->synchronized_entity;
    }

    public function setSynchronizedEntity(string $synchronized_entity): self
    {
        $this->synchronized_entity = $synchronized_entity;

        return $this;
    }

    public function getSynchronizedData(): ?array
    {
        return $this->synchronized_data;
    }

    public function setSynchronizedData(?array $synchronized_data): self
    {
        $this->synchronized_data = $synchronized_data;

        return $this;
    }
}
