<?php

namespace App\Entity;

use App\Repository\GithubOrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GithubOrganizationRepository::class)]
class GithubOrganization
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
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $repos_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $events_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $hooks_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $issues_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $members_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $public_members_url;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatar_url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $twitter_username;

    #[ORM\Column(type: 'boolean')]
    private $is_verified;

    #[ORM\Column(type: 'boolean')]
    private $has_organization_projects;

    #[ORM\Column(type: 'boolean')]
    private $has_repository_projects;

    #[ORM\Column(type: 'integer')]
    private $public_repos;

    #[ORM\Column(type: 'integer')]
    private $public_gists;

    #[ORM\Column(type: 'integer')]
    private $followers;

    #[ORM\Column(type: 'integer')]
    private $following;

    #[ORM\Column(type: 'string', length: 255)]
    private $html_url;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 15)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $total_private_repos;

    #[ORM\Column(type: 'integer')]
    private $owned_private_repos;

    #[ORM\Column(type: 'integer')]
    private $private_gists;

    #[ORM\Column(type: 'integer')]
    private $disk_usage;

    #[ORM\Column(type: 'integer')]
    private $collaborators;

    #[ORM\Column(type: 'string', length: 255)]
    private $billing_email;

    #[ORM\Column(type: 'string', length: 15)]
    private $default_repository_permission;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_repositories;

    #[ORM\Column(type: 'boolean')]
    private $two_factor_requirement_enabled;

    #[ORM\Column(type: 'string', length: 15)]
    private $members_allowed_repository_creation_type;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_public_repositories;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_private_repositories;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_internal_repositories;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_pages;

    #[ORM\Column(type: 'boolean')]
    private $members_can_fork_private_repositories;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_public_pages;

    #[ORM\Column(type: 'boolean')]
    private $members_can_create_private_pages;

    #[ORM\Column(type: 'boolean')]
    private $web_commit_signoff_required;

    #[ORM\Column(type: 'json')]
    private $plan = [];

    #[ORM\ManyToMany(targetEntity: GithubUser::class, mappedBy: 'organizations')]
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getHooksUrl(): ?string
    {
        return $this->hooks_url;
    }

    public function setHooksUrl(string $hooks_url): self
    {
        $this->hooks_url = $hooks_url;

        return $this;
    }

    public function getIssuesUrl(): ?string
    {
        return $this->issues_url;
    }

    public function setIssuesUrl(string $issues_url): self
    {
        $this->issues_url = $issues_url;

        return $this;
    }

    public function getMembersUrl(): ?string
    {
        return $this->members_url;
    }

    public function setMembersUrl(string $members_url): self
    {
        $this->members_url = $members_url;

        return $this;
    }

    public function getPublicMembersUrl(): ?string
    {
        return $this->public_members_url;
    }

    public function setPublicMembersUrl(string $public_members_url): self
    {
        $this->public_members_url = $public_members_url;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getTwitterUsername(): ?string
    {
        return $this->twitter_username;
    }

    public function setTwitterUsername(?string $twitter_username): self
    {
        $this->twitter_username = $twitter_username;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;

        return $this;
    }

    public function isHasOrganizationProjects(): ?bool
    {
        return $this->has_organization_projects;
    }

    public function setHasOrganizationProjects(bool $has_organization_projects): self
    {
        $this->has_organization_projects = $has_organization_projects;

        return $this;
    }

    public function isHasRepositoryProjects(): ?bool
    {
        return $this->has_repository_projects;
    }

    public function setHasRepositoryProjects(bool $has_repository_projects): self
    {
        $this->has_repository_projects = $has_repository_projects;

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

    public function getHtmlUrl(): ?string
    {
        return $this->html_url;
    }

    public function setHtmlUrl(string $html_url): self
    {
        $this->html_url = $html_url;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getPrivateGists(): ?int
    {
        return $this->private_gists;
    }

    public function setPrivateGists(int $private_gists): self
    {
        $this->private_gists = $private_gists;

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

    public function getBillingEmail(): ?string
    {
        return $this->billing_email;
    }

    public function setBillingEmail(string $billing_email): self
    {
        $this->billing_email = $billing_email;

        return $this;
    }

    public function getDefaultRepositoryPermission(): ?string
    {
        return $this->default_repository_permission;
    }

    public function setDefaultRepositoryPermission(string $default_repository_permission): self
    {
        $this->default_repository_permission = $default_repository_permission;

        return $this;
    }

    public function isMembersCanCreateRepositories(): ?bool
    {
        return $this->members_can_create_repositories;
    }

    public function setMembersCanCreateRepositories(bool $members_can_create_repositories): self
    {
        $this->members_can_create_repositories = $members_can_create_repositories;

        return $this;
    }

    public function isTwoFactorRequirementEnabled(): ?bool
    {
        return $this->two_factor_requirement_enabled;
    }

    public function setTwoFactorRequirementEnabled(bool $two_factor_requirement_enabled): self
    {
        $this->two_factor_requirement_enabled = $two_factor_requirement_enabled;

        return $this;
    }

    public function getMembersAllowedRepositoryCreationType(): ?string
    {
        return $this->members_allowed_repository_creation_type;
    }

    public function setMembersAllowedRepositoryCreationType(
        string $members_allowed_repository_creation_type,
    ): self {
        $this->members_allowed_repository_creation_type = $members_allowed_repository_creation_type;

        return $this;
    }

    public function isMembersCanCreatePublicRepositories(): ?bool
    {
        return $this->members_can_create_public_repositories;
    }

    public function setMembersCanCreatePublicRepositories(
        bool $members_can_create_public_repositories,
    ): self {
        $this->members_can_create_public_repositories = $members_can_create_public_repositories;

        return $this;
    }

    public function isMembersCanCreatePrivateRepositories(): ?bool
    {
        return $this->members_can_create_private_repositories;
    }

    public function setMembersCanCreatePrivateRepositories(
        bool $members_can_create_private_repositories,
    ): self {
        $this->members_can_create_private_repositories = $members_can_create_private_repositories;

        return $this;
    }

    public function isMembersCanCreateInternalRepositories(): ?bool
    {
        return $this->members_can_create_internal_repositories;
    }

    public function setMembersCanCreateInternalRepositories(
        bool $members_can_create_internal_repositories,
    ): self {
        $this->members_can_create_internal_repositories = $members_can_create_internal_repositories;

        return $this;
    }

    public function isMembersCanCreatePages(): ?bool
    {
        return $this->members_can_create_pages;
    }

    public function setMembersCanCreatePages(bool $members_can_create_pages): self
    {
        $this->members_can_create_pages = $members_can_create_pages;

        return $this;
    }

    public function isMembersCanForkPrivateRepositories(): ?bool
    {
        return $this->members_can_fork_private_repositories;
    }

    public function setMembersCanForkPrivateRepositories(
        bool $members_can_fork_private_repositories,
    ): self {
        $this->members_can_fork_private_repositories = $members_can_fork_private_repositories;

        return $this;
    }

    public function isMembersCanCreatePublicPages(): ?bool
    {
        return $this->members_can_create_public_pages;
    }

    public function setMembersCanCreatePublicPages(bool $members_can_create_public_pages): self
    {
        $this->members_can_create_public_pages = $members_can_create_public_pages;

        return $this;
    }

    public function isMembersCanCreatePrivatePages(): ?bool
    {
        return $this->members_can_create_private_pages;
    }

    public function setMembersCanCreatePrivatePages(bool $members_can_create_private_pages): self
    {
        $this->members_can_create_private_pages = $members_can_create_private_pages;

        return $this;
    }

    public function isWebCommitSignoffRequired(): ?bool
    {
        return $this->web_commit_signoff_required;
    }

    public function setWebCommitSignoffRequired(bool $web_commit_signoff_required): self
    {
        $this->web_commit_signoff_required = $web_commit_signoff_required;

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

    /**
     * @return Collection<int, GithubUser>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(GithubUser $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->addOrganization($this);
        }

        return $this;
    }

    public function removeMember(GithubUser $member): self
    {
        if ($this->members->removeElement($member)) {
            $member->removeOrganization($this);
        }

        return $this;
    }
}
