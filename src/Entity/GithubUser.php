<?php

namespace App\Entity;

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

    #[ORM\Column(type: 'string', length: 255)]
    private $login;

    #[ORM\Column(type: 'integer')]
    private $github_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $node_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatar_url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gravatar_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $html_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $followers_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $following_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $gists_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $starred_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $subscriptions_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $organizations_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $repos_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $events_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $received_events_url;

    #[ORM\Column(type: 'string', length: 15)]
    private $type;

    #[ORM\Column(type: 'boolean')]
    private $site_admin;

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
    private $twitter_username;

    #[ORM\Column(type: 'integer')]
    private $public_repos;

    #[ORM\Column(type: 'integer')]
    private $public_gists;

    #[ORM\Column(type: 'integer')]
    private $followers;

    #[ORM\Column(type: 'integer')]
    private $following;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'integer')]
    private $private_gists;

    #[ORM\Column(type: 'integer')]
    private $total_private_repos;

    #[ORM\Column(type: 'integer')]
    private $owned_private_repos;

    #[ORM\Column(type: 'integer')]
    private $disk_usage;

    #[ORM\Column(type: 'integer')]
    private $collaborators;

    #[ORM\Column(type: 'boolean')]
    private $two_factor_authentication;

    #[ORM\Column(type: 'json')]
    private $plan = [];

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

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function setAvatarUrl(string $avatar_url): self
    {
        $this->avatar_url = $avatar_url;

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
        return $this->html_url;
    }

    public function setHtmlUrl(string $html_url): self
    {
        $this->html_url = $html_url;

        return $this;
    }

    public function getFollowersUrl(): ?string
    {
        return $this->followers_url;
    }

    public function setFollowersUrl(string $followers_url): self
    {
        $this->followers_url = $followers_url;

        return $this;
    }

    public function getFollowingUrl(): ?string
    {
        return $this->following_url;
    }

    public function setFollowingUrl(string $following_url): self
    {
        $this->following_url = $following_url;

        return $this;
    }

    public function getGistsUrl(): ?string
    {
        return $this->gists_url;
    }

    public function setGistsUrl(string $gists_url): self
    {
        $this->gists_url = $gists_url;

        return $this;
    }

    public function getStarredUrl(): ?string
    {
        return $this->starred_url;
    }

    public function setStarredUrl(string $starred_url): self
    {
        $this->starred_url = $starred_url;

        return $this;
    }

    public function getSubscriptionsUrl(): ?string
    {
        return $this->subscriptions_url;
    }

    public function setSubscriptionsUrl(string $subscriptions_url): self
    {
        $this->subscriptions_url = $subscriptions_url;

        return $this;
    }

    public function getOrganizationsUrl(): ?string
    {
        return $this->organizations_url;
    }

    public function setOrganizationsUrl(string $organizations_url): self
    {
        $this->organizations_url = $organizations_url;

        return $this;
    }

    public function getReposUrl(): ?string
    {
        return $this->repos_url;
    }

    public function setReposUrl(string $repos_url): self
    {
        $this->repos_url = $repos_url;

        return $this;
    }

    public function getEventsUrl(): ?string
    {
        return $this->events_url;
    }

    public function setEventsUrl(string $events_url): self
    {
        $this->events_url = $events_url;

        return $this;
    }

    public function getReceivedEventsUrl(): ?string
    {
        return $this->received_events_url;
    }

    public function setReceivedEventsUrl(string $received_events_url): self
    {
        $this->received_events_url = $received_events_url;

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
        return $this->site_admin;
    }

    public function setSiteAdmin(bool $site_admin): self
    {
        $this->site_admin = $site_admin;

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
        return $this->twitter_username;
    }

    public function setTwitterUsername(?string $twitter_username): self
    {
        $this->twitter_username = $twitter_username;

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

    public function getPublicGists(): ?int
    {
        return $this->public_gists;
    }

    public function setPublicGists(int $public_gists): self
    {
        $this->public_gists = $public_gists;

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

    public function getPrivateGists(): ?int
    {
        return $this->private_gists;
    }

    public function setPrivateGists(int $private_gists): self
    {
        $this->private_gists = $private_gists;

        return $this;
    }

    public function getTotalPrivateRepos(): ?int
    {
        return $this->total_private_repos;
    }

    public function setTotalPrivateRepos(int $total_private_repos): self
    {
        $this->total_private_repos = $total_private_repos;

        return $this;
    }

    public function getOwnedPrivateRepos(): ?int
    {
        return $this->owned_private_repos;
    }

    public function setOwnedPrivateRepos(int $owned_private_repos): self
    {
        $this->owned_private_repos = $owned_private_repos;

        return $this;
    }

    public function getDiskUsage(): ?int
    {
        return $this->disk_usage;
    }

    public function setDiskUsage(int $disk_usage): self
    {
        $this->disk_usage = $disk_usage;

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
        return $this->two_factor_authentication;
    }

    public function setTwoFactorAuthentication(bool $two_factor_authentication): self
    {
        $this->two_factor_authentication = $two_factor_authentication;

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
}
