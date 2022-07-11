<?php

namespace App\Controller\Admin;

use App\Entity\Github\GithubUser;
use App\Entity\User;
use App\Repository\GithubUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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
            ->setPageTitle('index', 'Listado - Usuarios');

        // in DETAIL and EDIT pages, the closure receives the current entity
        // as the first argument
        // ->setPageTitle('detail', fn (Product $product) => (string) $product)
        // ->setPageTitle('edit', fn (Category $category) => sprintf('Editing <b>%s</b>', $category->getName()))

        // the help message displayed to end users (it can contain HTML tags)
        // ->setHelp('edit', '...');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')->hideOnForm(),
            TextField::new('name', 'Nombre'),
            EmailField::new('email', 'E-mail'),
            TextField::new('plainPassword', 'Contraseña')->onlyOnForms(),
            ArrayField::new('roles', 'Roles'),
            TextField::new(
                'github_username',
                'Github - Username',
            )->onlyWhenUpdating(),
            TextField::new(
                'github_pa_token',
                'Github - Personal access token',
            )->onlyWhenUpdating(),
            ChoiceField::new('github_usertype', 'Github - User Type')
                ->setChoices(
                    fn() => [
                        'User' => 'User',
                        'Organization' => 'Organization',
                    ],
                )
                ->onlyWhenUpdating(),
            BooleanField::new('isVerified', 'Verificado')->onlyOnForms(),
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
            ->setRoles(['ROLE_ADMIN'])
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

            $type = $github_usertype
                ? ($github_usertype == 'User'
                    ? 'users'
                    : 'orgs')
                : 'users';

            $uri = "/{$type}/{$github_username}";

            $response = $client->request('GET', $uri, [
                'headers' => [
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => "token {$github_pa_token}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $x_ratelimit_limit = $response->getHeaderLine(
                    'x-ratelimit-limit',
                );

                $body = json_decode($response->getBody(), true);

                if (
                    $x_ratelimit_limit >= 5000 &&
                    !empty($body) &&
                    isset($body['id'])
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
                        ->setGithubId($body['id'])
                        ->setCreatedAt(
                            new \DateTimeImmutable($body['created_at']),
                        )
                        ->setUpdatedAt(
                            new \DateTimeImmutable($body['updated_at']),
                        )
                        ->setName($body['name'])
                        ->setAvatarUrl($body['avatar_url'])
                        ->setHtmlUrl($body['html_url'])
                        ->setType($body['type'])
                        ->setEmail($body['email'])
                        ->setPublicRepos($body['public_repos']);

                    $entityManager->persist($githubUser);
                    $entityInstance->setGithubUser($githubUser);
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
