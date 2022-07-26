<?php

namespace App\Utility;

use App\Entity\GithubOrganization;
use App\Entity\GithubUser;
use App\Repository\GithubOrganizationRepository;
use App\Repository\GithubUserRepository;
use Doctrine\ORM\EntityManagerInterface;

class GithubDataSync
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * Undocumented function
     *
     * @param array $body
     * @return GithubUser
     */
    public function userSync(array $body): GithubUser
    {
        /**
         * @var GithubUserRepository $repo
         */
        $repo = $this->entityManager->getRepository(GithubUser::class);

        $githubUser = $repo->findOneBy([
            'github_id' => $body['id'],
        ]);

        $githubUser = $githubUser ? $githubUser : new GithubUser();

        $githubUser
            ->setLogin($body['login'])
            ->setGithubId($body['id'])
            ->setNodeId($body['node_id'])
            ->setAvatarUrl($body['avatar_url'])
            ->setGravatarId($body['gravatar_id'])
            ->setUrl($body['url'])
            ->setHtmlUrl($body['html_url'])
            ->setFollowersUrl($body['followers_url'])
            ->setFollowingUrl($body['following_url'])
            ->setGistsUrl($body['gists_url'])
            ->setStarredUrl($body['starred_url'])
            ->setSubscriptionsUrl($body['subscriptions_url'])
            ->setOrganizationsUrl($body['organizations_url'])
            ->setReposUrl($body['repos_url'])
            ->setEventsUrl($body['events_url'])
            ->setReceivedEventsUrl($body['received_events_url'])
            ->setType($body['type'])
            ->setSiteAdmin($body['site_admin'])
            ->setName($body['name'])
            ->setCompany($body['company'])
            ->setBlog($body['blog'])
            ->setLocation($body['location'])
            ->setEmail($body['email'])
            //Verify value type
            // ->setHireable($body['hireable'])
            ->setBio($body['bio'])
            ->setTwitterUsername($body['twitter_username'])
            ->setPublicRepos($body['public_repos'])
            ->setPublicGists($body['public_gists'])
            ->setFollowers($body['followers'])
            ->setFollowing($body['following'])
            ->setCreatedAt(new \DateTimeImmutable($body['created_at']))
            ->setUpdatedAt(new \DateTimeImmutable($body['updated_at']))
            ->setPrivateGists($body['private_gists'])
            ->setTotalPrivateRepos($body['total_private_repos'])
            ->setOwnedPrivateRepos($body['owned_private_repos'])
            ->setDiskUsage($body['disk_usage'])
            ->setCollaborators($body['collaborators'])
            ->setTwoFactorAuthentication($body['two_factor_authentication'])
            ->setPlan(
                $body['plan'],
                //
            );
        return $githubUser;
    }

    /**
     * Undocumented function
     *
     * @param array $body
     * @return GithubOrganization
     */
    public function organizationSync(array $body): GithubOrganization
    {
        /**
         * @var GithubOrganizationRepository $repo
         */
        $repo = $this->entityManager->getRepository(GithubOrganization::class);

        $githubOrganization = $repo->findOneBy([
            'github_id' => $body['id'],
        ]);

        $githubOrganization = $githubOrganization ? $githubOrganization : new GithubOrganization();

        $githubOrganization
            ->setLogin($body['login'])
            ->setGithubId($body['id'])
            ->setNodeId($body['node_id'])
            ->setUrl($body['url'])
            ->setReposUrl($body['repos_url'])
            ->setEventsUrl($body['events_url'])
            ->setHooksUrl($body['hooks_url'])
            ->setIssuesUrl($body['issues_url'])
            ->setMembersUrl($body['members_url'])
            ->setPublicMembersUrl($body['public_members_url'])
            ->setAvatarUrl($body['avatar_url'])
            ->setDescription($body['description'])
            ->setName($body['name'])
            ->setCompany($body['company'])
            ->setBlog($body['blog'])
            ->setLocation($body['location'])
            ->setEmail($body['email'])
            ->setTwitterUsername($body['twitter_username'])
            ->setIsVerified($body['is_verified'])
            ->setHasOrganizationProjects($body['has_organization_projects'])
            ->setHasRepositoryProjects($body['has_repository_projects'])
            ->setPublicRepos($body['public_repos'])
            ->setPublicGists($body['public_gists'])
            ->setFollowers($body['followers'])
            ->setFollowing($body['following'])
            ->setHtmlUrl($body['html_url'])
            ->setCreatedAt(new \DateTimeImmutable($body['created_at']))
            ->setUpdatedAt(new \DateTimeImmutable($body['updated_at']))
            ->setType($body['type'])
            ->setTotalPrivateRepos($body['total_private_repos'])
            ->setOwnedPrivateRepos($body['owned_private_repos'])
            ->setPrivateGists($body['private_gists'])
            ->setDiskUsage($body['disk_usage'])
            ->setCollaborators($body['collaborators'])
            ->setBillingEmail($body['billing_email'])
            ->setDefaultRepositoryPermission($body['default_repository_permission'])
            ->setMembersCanCreateRepositories($body['members_can_create_repositories'])
            ->setTwoFactorRequirementEnabled($body['two_factor_requirement_enabled'])
            ->setMembersAllowedRepositoryCreationType(
                $body['members_allowed_repository_creation_type'],
            )
            ->setMembersCanCreatePublicRepositories($body['members_can_create_public_repositories'])
            ->setMembersCanCreatePrivateRepositories(
                $body['members_can_create_private_repositories'],
            )
            ->setMembersCanCreateInternalRepositories(
                $body['members_can_create_internal_repositories'],
            )
            ->setMembersCanCreatePages($body['members_can_create_pages'])
            ->setMembersCanForkPrivateRepositories($body['members_can_fork_private_repositories'])
            ->setMembersCanCreatePublicPages($body['members_can_create_public_pages'])
            ->setMembersCanCreatePrivatePages($body['members_can_create_private_pages'])
            ->setWebCommitSignoffRequired($body['web_commit_signoff_required'])
            ->setPlan(
                $body['plan'],

                //
            );

        return $githubOrganization;
    }
}
