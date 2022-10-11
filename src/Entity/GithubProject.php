<?php

namespace App\Entity;

use App\Repository\GithubProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GithubProjectRepository::class)]
class GithubProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ownerUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $htmlUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $columnsUrl;

    #[ORM\Column(type: 'integer')]
    private $githubId;

    #[ORM\Column(type: 'string', length: 255)]
    private $nodeId;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $body;

    #[ORM\Column(type: 'string', length: 15)]
    private $state;

    #[ORM\Column(type: 'integer')]
    private $number;

    #[ORM\Column(type: 'json')]
    private $creator = [];

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 15)]
    private $organizationPermission;

    #[ORM\Column(type: 'boolean')]
    private $private;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerUrl(): ?string
    {
        return $this->ownerUrl;
    }

    public function setOwnerUrl(string $ownerUrl): self
    {
        $this->ownerUrl = $ownerUrl;

        return $this;
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

    public function getHtmlUrl(): ?string
    {
        return $this->htmlUrl;
    }

    public function setHtmlUrl(string $htmlUrl): self
    {
        $this->htmlUrl = $htmlUrl;

        return $this;
    }

    public function getColumnsUrl(): ?string
    {
        return $this->columnsUrl;
    }

    public function setColumnsUrl(string $columnsUrl): self
    {
        $this->columnsUrl = $columnsUrl;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCreator(): ?array
    {
        return $this->creator;
    }

    public function setCreator(array $creator): self
    {
        $this->creator = $creator;

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

    public function getOrganizationPermission(): ?string
    {
        return $this->organizationPermission;
    }

    public function setOrganizationPermission(string $organizationPermission): self
    {
        $this->organizationPermission = $organizationPermission;

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

        return $this;
    }
}
