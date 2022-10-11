<?php

namespace App\Entity;

use App\Entity\GithubUser;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[
    UniqueEntity(
        fields: ['email'],
        message: 'There is already an account with this email',
    ),
]
#[ApiResource(security: "is_granted('ROLE_USER')")]
#[
    ApiFilter(
        DateFilter::class,
        properties: ['createdAt', 'updatedAt' => DateFilter::EXCLUDE_NULL],
    ),
]
#[
    ApiFilter(
        SearchFilter::class,
        properties: [
            'email' => 'partial',
            'name' => 'partial',
            'roles' => 'partial',
        ],
    ),
]
#[ApiFilter(NumericFilter::class, properties: ['status'])]
#[ApiFilter(BooleanFilter::class, properties: ['isVerified'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[
        ORM\Column(
            type: 'smallint',
            nullable: false,
            options: ['unsigned' => true, 'default' => 0],
        ),
    ]
    private $status = 0;

    #[
        Assert\Email(
            message: "El correo electrónico '{{ value }}' no es un correo electrónico válido.",
            mode: 'html5',
        ),
    ]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ApiProperty(security: "is_granted('ROLE_ADMIN')")]
    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[
        Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Su contraseña debe tener al menos {{ limit }} caracteres',
            maxMessage: 'Su contraseña debe tener más de {{ limit }} caracteres',
        ),
    ]
    #[
        Assert\NotBlank(
            message: 'La contraseña no puede estar vacía',
            groups: ['create'],
        ),
    ]
    #[SerializedName('password')]
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
    private $githubUser;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $githubPaToken;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $githubUsername;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $githubUsertype;

    #[ORM\Column(type: 'json', nullable: true)]
    private $githubPaTokenScope = [];

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $githubPaTokenExpiration;

    #[
        ORM\OneToMany(
            mappedBy: 'user',
            targetEntity: TimeRecord::class,
            orphanRemoval: true,
        ),
    ]
    private $timeRecords;

    public function __construct()
    {
        $this->timeRecords = new ArrayCollection();
    }

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
        return $this->githubUser;
    }

    public function setGithubUser(?GithubUser $githubUser): self
    {
        $this->githubUser = $githubUser;

        return $this;
    }

    public function getGithubPaToken(): ?string
    {
        return $this->githubPaToken;
    }

    public function setGithubPaToken(?string $githubPaToken): self
    {
        $this->githubPaToken = $githubPaToken;

        return $this;
    }

    public function getGithubUsername(): ?string
    {
        return $this->githubUsername;
    }

    public function setGithubUsername(?string $githubUsername): self
    {
        $this->githubUsername = $githubUsername;

        return $this;
    }

    public function getGithubUsertype(): ?string
    {
        return $this->githubUsertype;
    }

    public function setGithubUsertype(?string $githubUsertype): self
    {
        $this->githubUsertype = $githubUsertype;

        return $this;
    }

    public function getGithubPaTokenScope(): ?array
    {
        return $this->githubPaTokenScope;
    }

    public function setGithubPaTokenScope(?array $githubPaTokenScope): self
    {
        $this->githubPaTokenScope = $githubPaTokenScope;

        return $this;
    }

    public function getGithubPaTokenExpiration(): ?\DateTimeImmutable
    {
        return $this->githubPaTokenExpiration;
    }

    public function setGithubPaTokenExpiration(
        ?\DateTimeImmutable $githubPaTokenExpiration,
    ): self {
        $this->githubPaTokenExpiration = $githubPaTokenExpiration;

        return $this;
    }

    /**
     * @return Collection<int, TimeRecord>
     */
    public function getTimeRecords(): Collection
    {
        return $this->timeRecords;
    }

    public function addTimeRecord(TimeRecord $timeRecord): self
    {
        if (!$this->timeRecords->contains($timeRecord)) {
            $this->timeRecords[] = $timeRecord;
            $timeRecord->setUser($this);
        }

        return $this;
    }

    public function removeTimeRecord(TimeRecord $timeRecord): self
    {
        if ($this->timeRecords->removeElement($timeRecord)) {
            // set the owning side to null (unless already changed)
            if ($timeRecord->getUser() === $this) {
                $timeRecord->setUser(null);
            }
        }

        return $this;
    }
}
