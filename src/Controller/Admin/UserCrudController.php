<?php

namespace App\Controller\Admin;

use App\Entity\GithubUser;
use App\Entity\User;
use App\Repository\GithubUserRepository;
use App\Utility\GithubUtility;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[IsGranted('ROLE_SUPER_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the visible title at the top of the page and the content of the <title> element
            // it can include these placeholders:
            //   %entity_name%, %entity_as_string%,
            //   %entity_id%, %entity_short_id%
            //   %entity_label_singular%, %entity_label_plural%
            ->setPageTitle('index', 'Listado - Usuarios')
            ->showEntityActionsInlined()

            // in DETAIL and EDIT pages, the closure receives the current entity
            // as the first argument
            // ->setPageTitle('detail', fn (Product $product) => (string) $product)
            // ->setPageTitle('edit', fn (Category $category) => sprintf('Editing <b>%s</b>', $category->getName()))

            // the help message displayed to end users (it can contain HTML tags)
            // ->setHelp('edit', '...');
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            TextField::new('name', 'Nombre'),
            EmailField::new('email', 'E-mail'),
            TextField::new('plainPassword', 'Contraseña')->setFormType(PasswordType::class)->onlyOnForms(),
            ArrayField::new('roles', 'Roles'),
            ArrayField::new('github_pa_token_scope', 'Github - Scopes')->onlyOnDetail(),
            TextField::new(
                'github_username',
                'Github - Username',
            )->onlyWhenUpdating(),
            TextField::new(
                'github_pa_token',
                'Github - Personal access token',
            )->hideOnIndex()->hideWhenCreating(),
            ChoiceField::new('github_usertype', 'Github - User Type')
                ->setChoices(
                    fn () => [
                        'User' => 'User',
                        'Organization' => 'Organization',
                    ],
                )
                ->hideOnIndex()->hideWhenCreating(),
            BooleanField::new('isVerified', 'Verificado'),
            AssociationField::new('github_user')->hideOnForm()
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('id', 'ID'))
            ->add(TextFilter::new('name', 'Nombre'))
            ->add(TextFilter::new('roles', 'Roles'))
            ->add(TextFilter::new('email', 'E-mail'))
            ->add(BooleanFilter::new('isVerified', 'Verificado'));
    }

    public function createEntity(string $entityFqcn)
    {
        return new $entityFqcn();
    }

    /**
     * persistEntity function
     *
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance,
    ): void {
        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword(),
                ),
            );

            $entityInstance->eraseCredentials();
        }

        $entityInstance
            ->setCreatedAt(new \DateTimeImmutable('now'));

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    /**
     * updateEntity function
     *
     * @param EntityManagerInterface $entityManager
     * @param User $entityInstance
     * @return void
     */
    public function updateEntity(
        EntityManagerInterface $entityManager,
        $entityInstance,
    ): void {
        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword(),
                ),
            );

            $entityInstance->eraseCredentials();
        }

        $entityInstance->setUpdatedAt(new \DateTimeImmutable('now'));

        $github_usertype = $entityInstance->getGithubUsertype();
        $github_username = $entityInstance->getGithubUsername();
        $github_pa_token = $entityInstance->getGithubPaToken();

        if ($github_pa_token && $github_username) {
            $client = new Client(['base_uri' => 'https://api.github.com/']);

            $uri = "/users/{$github_username}";

            $response = $client->request('GET', $uri, [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "token {$github_pa_token}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {

                $x_oauth_scopes = GithubUtility::HeaderScopesDecode($response->getHeaderLine('X-OAuth-Scopes'));

                $body = json_decode($response->getBody(), true);

                // dump($body);
                // die();

                if (
                    !empty($x_oauth_scopes) && !empty($body) && isset($body['id'])
                ) {

                    /**
                     * @var GithubUserRepository $githubUserRepo
                     */
                    $githubUserRepo = $entityManager->getRepository(
                        GithubUser::class,
                    );

                    $githubUser = $githubUserRepo->findOneBy([
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
                        ->setCreatedAt(
                            new \DateTimeImmutable($body['created_at']),
                        )
                        ->setUpdatedAt(
                            new \DateTimeImmutable($body['updated_at']),
                        )
                        ->setPrivateGists($body['private_gists'])
                        ->setTotalPrivateRepos($body['total_private_repos'])
                        ->setOwnedPrivateRepos($body['owned_private_repos'])
                        ->setDiskUsage($body['disk_usage'])
                        ->setCollaborators($body['collaborators'])
                        ->setTwoFactorAuthentication($body['two_factor_authentication'])
                        ->setPlan($body['plan'])
                        //
                    ;

                    $entityManager->persist($githubUser);

                    $entityInstance->setGithubUser($githubUser);
                    $entityInstance->setGithubPaTokenScope($x_oauth_scopes);

                    $github_pa_token_expiration = $response->getHeaderLine('github-authentication-token-expiration');
                    $github_pa_token_expiration = $github_pa_token_expiration ? new \DateTimeImmutable($github_pa_token_expiration) : null;
                    $entityInstance->setGithubPaTokenExpiration($github_pa_token_expiration);
                }
            }
        }

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
