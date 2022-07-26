<?php

namespace App\Entity;

use App\Repository\GithubCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GithubCardRepository::class)]
class GithubCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $project_url;

    #[ORM\Column(type: 'integer')]
    private $github_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $node_id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $note;

    #[ORM\Column(type: 'boolean')]
    private $archived;

    #[ORM\Column(type: 'json')]
    private $creator = [];

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $column_url;

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
        return $this->project_url;
    }

    public function setProjectUrl(string $project_url): self
    {
        $this->project_url = $project_url;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

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

    public function getColumnUrl(): ?string
    {
        return $this->column_url;
    }

    public function setColumnUrl(string $column_url): self
    {
        $this->column_url = $column_url;

        return $this;
    }
}
