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
    private $owner_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $html_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $columns_url;

    #[ORM\Column(type: 'integer')]
    private $github_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $node_id;

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
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 15)]
    private $organization_permission;

    #[ORM\Column(type: 'boolean')]
    private $private;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnerUrl(): ?string
    {
        return $this->owner_url;
    }

    public function setOwnerUrl(string $owner_url): self
    {
        $this->owner_url = $owner_url;

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
        return $this->html_url;
    }

    public function setHtmlUrl(string $html_url): self
    {
        $this->html_url = $html_url;

        return $this;
    }

    public function getColumnsUrl(): ?string
    {
        return $this->columns_url;
    }

    public function setColumnsUrl(string $columns_url): self
    {
        $this->columns_url = $columns_url;

        return $this;
    }

    public function getGithubId(): ?int
    {
        return $this->github_id;
    }

    public function setGithubId(int $github_id): self
    {
        $this->github_id = $github_id;

        return $this;
    }

    public function getNodeId(): ?string
    {
        return $this->node_id;
    }

    public function setNodeId(string $node_id): self
    {
        $this->node_id = $node_id;

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

    public function getOrganizationPermission(): ?string
    {
        return $this->organization_permission;
    }

    public function setOrganizationPermission(
        string $organization_permission,
    ): self {
        $this->organization_permission = $organization_permission;

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
