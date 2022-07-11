<?php

namespace App\Entity;

use App\Entity\Github\GithubUser;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[
    UniqueEntity(
        fields: ['email'],
        message: 'There is already an account with this email',
    ),
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private $status = 0;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    private $plainPassword;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[
        ORM\OneToOne(
            inversedBy: 'user',
            targetEntity: GithubUser::class,
            cascade: ['persist', 'remove'],
        ),
    ]
    private $github_user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $github_pa_token;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $github_username;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $github_usertype;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?: $this->email ?: '';
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGithubUser(): ?GithubUser
    {
        return $this->github_user;
    }

    public function setGithubUser(?GithubUser $github_user): self
    {
        $this->github_user = $github_user;

        return $this;
    }

    public function getGithubPaToken(): ?string
    {
        return $this->github_pa_token;
    }

    public function setGithubPaToken(?string $github_pa_token): self
    {
        $this->github_pa_token = $github_pa_token;

        return $this;
    }

    public function getGithubUsername(): ?string
    {
        return $this->github_username;
    }

    public function setGithubUsername(?string $github_username): self
    {
        $this->github_username = $github_username;

        return $this;
    }

    public function getGithubUsertype(): ?string
    {
        return $this->github_usertype;
    }

    public function setGithubUsertype(?string $github_usertype): self
    {
        $this->github_usertype = $github_usertype;

        return $this;
    }
}
