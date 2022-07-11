<?php

namespace App\Entity\Github;

use App\Entity\User;
use App\Repository\GithubUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GithubUserRepository::class)]
class GithubUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $github_id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatar_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $html_url;

    #[ORM\Column(type: 'string', length: 15)]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'integer')]
    private $public_repos;

    #[
        ORM\OneToOne(
            mappedBy: 'github_user',
            targetEntity: User::class,
            cascade: ['persist', 'remove'],
        ),
    ]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function setAvatarUrl(string $avatar_url): self
    {
        $this->avatar_url = $avatar_url;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPublicRepos(): ?int
    {
        return $this->public_repos;
    }

    public function setPublicRepos(int $public_repos): self
    {
        $this->public_repos = $public_repos;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setGithubUser(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getGithubUser() !== $this) {
            $user->setGithubUser($this);
        }

        $this->user = $user;

        return $this;
    }
}
