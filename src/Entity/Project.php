<?php

namespace App\Entity;

use App\Entity\Github\GithubProject;
use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[
        ORM\Column(
            type: 'smallint',
            nullable: false,
            options: ['unsigned' => true, 'default' => 0],
        ),
    ]
    private $status;

    #[
        ORM\OneToOne(
            inversedBy: 'project',
            targetEntity: GithubProject::class,
            cascade: ['persist', 'remove'],
        ),
    ]
    private $github_project;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getGithubProject(): ?GithubProject
    {
        return $this->github_project;
    }

    public function setGithubProject(?GithubProject $github_project): self
    {
        $this->github_project = $github_project;

        return $this;
    }
}
