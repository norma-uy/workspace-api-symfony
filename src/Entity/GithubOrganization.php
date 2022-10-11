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
    private $githubId;

    #[ORM\Column(type: 'string', length: 255)]
    private $nodeId;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $reposUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $eventsUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $hooksUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $issuesUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $membersUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $public_membersUrl;

    #[ORM\Column(type: 'string', length: 255)]
    private $avatarUrl;

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
    private $twitterUsername;

    #[ORM\Column(type: 'boolean')]
    private $isVerified;

    #[ORM\Column(type: 'boolean')]
    private $hasOrganizationProjects;

    #[ORM\Column(type: 'boolean')]
    private $hasRepositoryProjects;

    #[ORM\Column(type: 'integer')]
    private $publicRepos;

    #[ORM\Column(type: 'integer')]
    private $publicGists;

    #[ORM\Column(type: 'integer')]
    private $followers;

    #[ORM\Column(type: 'integer')]
    private $following;

    #[ORM\Column(type: 'string', length: 255)]
    private $htmlUrl;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 15)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $totalPrivateRepos;

    #[ORM\Column(type: 'integer')]
    private $ownedPrivateRepos;

    #[ORM\Column(type: 'integer')]
    private $privateGists;

    #[ORM\Column(type: 'integer')]
    private $diskUsage;

    #[ORM\Column(type: 'integer')]
    private $collaborators;

    #[ORM\Column(type: 'string', length: 255)]
    private $billingEmail;

    #[ORM\Column(type: 'string', length: 15)]
    private $defaultRepositoryPermission;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreateRepositories;

    #[ORM\Column(type: 'boolean')]
    private $twoFactorRequirementEnabled;

    #[ORM\Column(type: 'string', length: 15)]
    private $membersAllowedRepositoryCreationType;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreatePublicRepositories;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreatePrivateRepositories;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreateInternalRepositories;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreatePages;

    #[ORM\Column(type: 'boolean')]
    private $membersCanForkPrivateRepositories;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreatePublicPages;

    #[ORM\Column(type: 'boolean')]
    private $membersCanCreatePrivatePages;

    #[ORM\Column(type: 'boolean')]
    private $webCommitSignoffRequired;

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

    public function getHooksUrl(): ?string
    {
        return $this->hooksUrl;
    }

    public function setHooksUrl(string $hooksUrl): self
    {
        $this->hooksUrl = $hooksUrl;

        return $this;
    }

    public function getIssuesUrl(): ?string
    {
        return $this->issuesUrl;
    }

    public function setIssuesUrl(string $issuesUrl): self
    {
        $this->issuesUrl = $issuesUrl;

        return $this;
    }

    public function getMembersUrl(): ?string
    {
        return $this->membersUrl;
    }

    public function setMembersUrl(string $membersUrl): self
    {
        $this->membersUrl = $membersUrl;

        return $this;
    }

    public function getPublicMembersUrl(): ?string
    {
        return $this->public_membersUrl;
    }

    public function setPublicMembersUrl(string $public_membersUrl): self
    {
        $this->public_membersUrl = $public_membersUrl;

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
        return $this->twitterUsername;
    }

    public function setTwitterUsername(?string $twitterUsername): self
    {
        $this->twitterUsername = $twitterUsername;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isHasOrganizationProjects(): ?bool
    {
        return $this->hasOrganizationProjects;
    }

    public function setHasOrganizationProjects(bool $hasOrganizationProjects): self
    {
        $this->hasOrganizationProjects = $hasOrganizationProjects;

        return $this;
    }

    public function isHasRepositoryProjects(): ?bool
    {
        return $this->hasRepositoryProjects;
    }

    public function setHasRepositoryProjects(bool $hasRepositoryProjects): self
    {
        $this->hasRepositoryProjects = $hasRepositoryProjects;

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

    public function getHtmlUrl(): ?string
    {
        return $this->htmlUrl;
    }

    public function setHtmlUrl(string $htmlUrl): self
    {
        $this->htmlUrl = $htmlUrl;

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

    public function getPrivateGists(): ?int
    {
        return $this->privateGists;
    }

    public function setPrivateGists(int $privateGists): self
    {
        $this->privateGists = $privateGists;

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

    public function getBillingEmail(): ?string
    {
        return $this->billingEmail;
    }

    public function setBillingEmail(string $billingEmail): self
    {
        $this->billingEmail = $billingEmail;

        return $this;
    }

    public function getDefaultRepositoryPermission(): ?string
    {
        return $this->defaultRepositoryPermission;
    }

    public function setDefaultRepositoryPermission(string $defaultRepositoryPermission): self
    {
        $this->defaultRepositoryPermission = $defaultRepositoryPermission;

        return $this;
    }

    public function isMembersCanCreateRepositories(): ?bool
    {
        return $this->membersCanCreateRepositories;
    }

    public function setMembersCanCreateRepositories(bool $membersCanCreateRepositories): self
    {
        $this->membersCanCreateRepositories = $membersCanCreateRepositories;

        return $this;
    }

    public function isTwoFactorRequirementEnabled(): ?bool
    {
        return $this->twoFactorRequirementEnabled;
    }

    public function setTwoFactorRequirementEnabled(bool $twoFactorRequirementEnabled): self
    {
        $this->twoFactorRequirementEnabled = $twoFactorRequirementEnabled;

        return $this;
    }

    public function getMembersAllowedRepositoryCreationType(): ?string
    {
        return $this->membersAllowedRepositoryCreationType;
    }

    public function setMembersAllowedRepositoryCreationType(
        string $membersAllowedRepositoryCreationType,
    ): self {
        $this->membersAllowedRepositoryCreationType = $membersAllowedRepositoryCreationType;

        return $this;
    }

    public function isMembersCanCreatePublicRepositories(): ?bool
    {
        return $this->membersCanCreatePublicRepositories;
    }

    public function setMembersCanCreatePublicRepositories(
        bool $membersCanCreatePublicRepositories,
    ): self {
        $this->membersCanCreatePublicRepositories = $membersCanCreatePublicRepositories;

        return $this;
    }

    public function isMembersCanCreatePrivateRepositories(): ?bool
    {
        return $this->membersCanCreatePrivateRepositories;
    }

    public function setMembersCanCreatePrivateRepositories(
        bool $membersCanCreatePrivateRepositories,
    ): self {
        $this->membersCanCreatePrivateRepositories = $membersCanCreatePrivateRepositories;

        return $this;
    }

    public function isMembersCanCreateInternalRepositories(): ?bool
    {
        return $this->membersCanCreateInternalRepositories;
    }

    public function setMembersCanCreateInternalRepositories(
        bool $membersCanCreateInternalRepositories,
    ): self {
        $this->membersCanCreateInternalRepositories = $membersCanCreateInternalRepositories;

        return $this;
    }

    public function isMembersCanCreatePages(): ?bool
    {
        return $this->membersCanCreatePages;
    }

    public function setMembersCanCreatePages(bool $membersCanCreatePages): self
    {
        $this->membersCanCreatePages = $membersCanCreatePages;

        return $this;
    }

    public function isMembersCanForkPrivateRepositories(): ?bool
    {
        return $this->membersCanForkPrivateRepositories;
    }

    public function setMembersCanForkPrivateRepositories(
        bool $membersCanForkPrivateRepositories,
    ): self {
        $this->membersCanForkPrivateRepositories = $membersCanForkPrivateRepositories;

        return $this;
    }

    public function isMembersCanCreatePublicPages(): ?bool
    {
        return $this->membersCanCreatePublicPages;
    }

    public function setMembersCanCreatePublicPages(bool $membersCanCreatePublicPages): self
    {
        $this->membersCanCreatePublicPages = $membersCanCreatePublicPages;

        return $this;
    }

    public function isMembersCanCreatePrivatePages(): ?bool
    {
        return $this->membersCanCreatePrivatePages;
    }

    public function setMembersCanCreatePrivatePages(bool $membersCanCreatePrivatePages): self
    {
        $this->membersCanCreatePrivatePages = $membersCanCreatePrivatePages;

        return $this;
    }

    public function isWebCommitSignoffRequired(): ?bool
    {
        return $this->webCommitSignoffRequired;
    }

    public function setWebCommitSignoffRequired(bool $webCommitSignoffRequired): self
    {
        $this->webCommitSignoffRequired = $webCommitSignoffRequired;

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
