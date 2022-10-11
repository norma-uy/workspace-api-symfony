<?php

namespace App\Entity;

use App\Repository\TimeRecordRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;

#[ORM\Entity(repositoryClass: TimeRecordRepository::class)]
#[ApiResource(security: "is_granted('ROLE_USER')")]
#[
    ApiFilter(
        DateFilter::class,
        properties: ['createdAt', 'updatedAt' => DateFilter::EXCLUDE_NULL],
    ),
]
#[ApiFilter(NumericFilter::class, properties: ['status'])]
class TimeRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'smallint', nullable: false, options: ['unsigned' => true, 'default' => 0])]
    private $status = 0;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $startTime;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $endTime;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'timeRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeImmutable $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeImmutable $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
