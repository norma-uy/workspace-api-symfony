<?php

namespace App\Entity;

use App\Repository\GithubColumnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GithubColumnRepository::class)]
class GithubColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $projectUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $cardsUrl;

    #[ORM\Column(type: 'integer')]
    private $githubId;

    #[ORM\Column(type: 'string', length: 255)]
    private $nodeId;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getProjectUrl(): ?string
    {
        return $this->projectUrl;
    }

    public function setProjectUrl(string $projectUrl): self
    {
        $this->projectUrl = $projectUrl;

        return $this;
    }

    public function getCardsUrl(): ?string
    {
        return $this->cardsUrl;
    }

    public function setCardsUrl(string $cardsUrl): self
    {
        $this->cardsUrl = $cardsUrl;

        return $this;
    }

    public function getGithubId(): ?int
    {
        return $this->githubId;
    }

    public function setGithubId(int $githubId): self
    {
        $this->githubId = $githubId;

        return $this;
    }

    public function getNodeId(): ?string
    {
        return $this->nodeId;
    }

    public function setNodeId(string $nodeId): self
    {
        $this->nodeId = $nodeId;

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
}
