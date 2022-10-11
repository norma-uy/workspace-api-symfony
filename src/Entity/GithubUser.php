<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\GithubUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: GithubUserRepository::class)]
class GithubUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $login;

    #[ORM\Column(type: 'integer')]
    private $githubId;

    #[ORM\Column(type: 'string', length: 255)]
    private $nodeId;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatarUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gravatar_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $htmlUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $followersUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $followingUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $gistsUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $starredUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $subscriptionsUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $organizationsUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $reposUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $eventsUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $receivedEventsUrl;

    #[ORM\Column(type: 'string', length: 15)]
    private $type;

    #[ORM\Column(type: 'boolean')]
    private $siteAdmin;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $company;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $blog;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $location;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $hireable;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $twitterUsername;

    #[ORM\Column(type: 'integer')]
    private $publicRepos;

    #[ORM\Column(type: 'integer')]
    private $publicGists;

    #[ORM\Column(type: 'integer')]
    private $followers;

    #[ORM\Column(type: 'integer')]
    private $following;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'integer')]
    private $privateGists;

    #[ORM\Column(type: 'integer')]
    private $totalPrivateRepos;

    #[ORM\Column(type: 'integer')]
    private $ownedPrivateRepos;

    #[ORM\Column(type: 'integer')]
    private $diskUsage;

    #[ORM\Column(type: 'integer')]
    private $collaborators;

    #[ORM\Column(type: 'boolean')]
    private $twoFactorAuthentication;

    #[ORM\Column(type: 'json')]
    private $plan = [];

    #[
        ORM\OneToOne(
            mappedBy: 'githubUser',
            targetEntity: User::class,
            cascade: ['persist', 'remove'],
        ),
    ]
    private $user;

    #[ORM\ManyToMany(targetEntity: GithubOrganization::class, inversedBy: 'members')]
    #[JoinTable(name: 'members')]
    private $organizations;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

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

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getGravatarId(): ?string
    {
        return $this->gravatar_id;
    }

    public function setGravatarId(?string $gravatar_id): self
    {
        $this->gravatar_id = $gravatar_id;

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

    public function getFollowersUrl(): ?string
    {
        return $this->followersUrl;
    }

    public function setFollowersUrl(string $followersUrl): self
    {
        $this->followersUrl = $followersUrl;

        return $this;
    }

    public function getFollowingUrl(): ?string
    {
        return $this->followingUrl;
    }

    public function setFollowingUrl(string $followingUrl): self
    {
        $this->followingUrl = $followingUrl;

        return $this;
    }

    public function getGistsUrl(): ?string
    {
        return $this->gistsUrl;
    }

    public function setGistsUrl(string $gistsUrl): self
    {
        $this->gistsUrl = $gistsUrl;

        return $this;
    }

    public function getStarredUrl(): ?string
    {
        return $this->starredUrl;
    }

    public function setStarredUrl(string $starredUrl): self
    {
        $this->starredUrl = $starredUrl;

        return $this;
    }

    public function getSubscriptionsUrl(): ?string
    {
        return $this->subscriptionsUrl;
    }

    public function setSubscriptionsUrl(string $subscriptionsUrl): self
    {
        $this->subscriptionsUrl = $subscriptionsUrl;

        return $this;
    }

    public function getOrganizationsUrl(): ?string
    {
        return $this->organizationsUrl;
    }

    public function setOrganizationsUrl(string $organizationsUrl): self
    {
        $this->organizationsUrl = $organizationsUrl;

        return $this;
    }

    public function getReposUrl(): ?string
    {
        return $this->reposUrl;
    }

    public function setReposUrl(string $reposUrl): self
    {
        $this->reposUrl = $reposUrl;

        return $this;
    }

    public function getEventsUrl(): ?string
    {
        return $this->eventsUrl;
    }

    public function setEventsUrl(string $eventsUrl): self
    {
        $this->eventsUrl = $eventsUrl;

        return $this;
    }

    public function getReceivedEventsUrl(): ?string
    {
        return $this->receivedEventsUrl;
    }

    public function setReceivedEventsUrl(string $receivedEventsUrl): self
    {
        $this->receivedEventsUrl = $receivedEventsUrl;

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

    public function isSiteAdmin(): ?bool
    {
        return $this->siteAdmin;
    }

    public function setSiteAdmin(bool $siteAdmin): self
    {
        $this->siteAdmin = $siteAdmin;

        return $this;
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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getBlog(): ?string
    {
        return $this->blog;
    }

    public function setBlog(?string $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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

    public function isHireable(): ?bool
    {
        return $this->hireable;
    }

    public function setHireable(?bool $hireable): self
    {
        $this->hireable = $hireable;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getTwitterUsername(): ?string
    {
        return $this->twitterUsername;
    }

    public function setTwitterUsername(?string $twitterUsername): self
    {
        $this->twitterUsername = $twitterUsername;

        return $this;
    }

    public function getPublicRepos(): ?int
    {
        return $this->publicRepos;
    }

    public function setPublicRepos(int $publicRepos): self
    {
        $this->publicRepos = $publicRepos;

        return $this;
    }

    public function getPublicGists(): ?int
    {
        return $this->publicGists;
    }

    public function setPublicGists(int $publicGists): self
    {
        $this->publicGists = $publicGists;

        return $this;
    }

    public function getFollowers(): ?int
    {
        return $this->followers;
    }

    public function setFollowers(int $followers): self
    {
        $this->followers = $followers;

        return $this;
    }

    public function getFollowing(): ?int
    {
        return $this->following;
    }

    public function setFollowing(int $following): self
    {
        $this->following = $following;

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

    public function getPrivateGists(): ?int
    {
        return $this->privateGists;
    }

    public function setPrivateGists(int $privateGists): self
    {
        $this->privateGists = $privateGists;

        return $this;
    }

    public function getTotalPrivateRepos(): ?int
    {
        return $this->totalPrivateRepos;
    }

    public function setTotalPrivateRepos(int $totalPrivateRepos): self
    {
        $this->totalPrivateRepos = $totalPrivateRepos;

        return $this;
    }

    public function getOwnedPrivateRepos(): ?int
    {
        return $this->ownedPrivateRepos;
    }

    public function setOwnedPrivateRepos(int $ownedPrivateRepos): self
    {
        $this->ownedPrivateRepos = $ownedPrivateRepos;

        return $this;
    }

    public function getDiskUsage(): ?int
    {
        return $this->diskUsage;
    }

    public function setDiskUsage(int $diskUsage): self
    {
        $this->diskUsage = $diskUsage;

        return $this;
    }

    public function getCollaborators(): ?int
    {
        return $this->collaborators;
    }

    public function setCollaborators(int $collaborators): self
    {
        $this->collaborators = $collaborators;

        return $this;
    }

    public function isTwoFactorAuthentication(): ?bool
    {
        return $this->twoFactorAuthentication;
    }

    public function setTwoFactorAuthentication(bool $twoFactorAuthentication): self
    {
        $this->twoFactorAuthentication = $twoFactorAuthentication;

        return $this;
    }

    public function getPlan(): ?array
    {
        return $this->plan;
    }

    public function setPlan(array $plan): self
    {
        $this->plan = $plan;

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

    public function __toString(): string
    {
        return $this->login ?: $this->email ?: $this->name ?: '';
    }

    /**
     * @return Collection<int, GithubOrganization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(GithubOrganization $organization): self
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations[] = $organization;
        }

        return $this;
    }

    public function removeOrganization(GithubOrganization $organization): self
    {
        $this->organizations->removeElement($organization);

        return $this;
    }
}
