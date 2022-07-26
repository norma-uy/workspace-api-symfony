<?php

namespace App\Controller\Admin;

use App\Entity\GithubUser;
use App\Entity\User;
use App\Repository\GithubUserRepository;
use App\Utility\GithubAPI;
use App\Utility\GithubDataSync;
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
        private GithubDataSync $githubDataSync,
        private GithubAPI $githubApi,
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
            ->showEntityActionsInlined();

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
            TextField::new('plainPassword', 'Contraseña')
                ->setFormType(PasswordType::class)
                ->onlyOnForms(),
            ArrayField::new('roles', 'Roles'),
            ArrayField::new('github_pa_token_scope', 'Github - Scopes')->onlyOnDetail(),
            TextField::new('github_username', 'Github - Username')->onlyWhenUpdating(),
            TextField::new('github_pa_token', 'Github - Personal access token')
                ->hideOnIndex()
                ->hideWhenCreating(),
            ChoiceField::new('github_usertype', 'Github - User Type')
                ->setChoices(
                    fn() => [
                        'User' => 'User',
                        'Organization' => 'Organization',
                    ],
                )
                ->hideOnIndex()
                ->hideWhenCreating(),
            BooleanField::new('isVerified', 'Verificado'),
            AssociationField::new('github_user')->hideOnForm(),
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
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword(),
                ),
            );

            $entityInstance->eraseCredentials();
        }

        $entityInstance->setCreatedAt(new \DateTimeImmutable('now'));

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
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
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

        $github_username = $entityInstance->getGithubUsername();
        $github_pa_token = $entityInstance->getGithubPaToken();

        $response = $this->githubApi->getUser($github_pa_token, $github_username);

        if ($response) {
            //get github scopes
            $x_oauth_scopes = GithubUtility::HeaderScopesDecode(
                $response->getHeaderLine('X-OAuth-Scopes'),
            );

            //get body request
            $body = json_decode($response->getBody(), true);

            if (!empty($x_oauth_scopes) && !empty($body) && isset($body['id'])) {
                //github user synchronization
                $githubUser = $this->githubDataSync->userSync($body);
                $entityManager->persist($githubUser);
                $entityInstance->setGithubUser($githubUser);

                //saving scopes
                $entityInstance->setGithubPaTokenScope($x_oauth_scopes);

                //Token expiration
                $github_pa_token_expiration = $response->getHeaderLine(
                    'github-authentication-token-expiration',
                );
                $github_pa_token_expiration = $github_pa_token_expiration
                    ? new \DateTimeImmutable($github_pa_token_expiration)
                    : null;
                $entityInstance->setGithubPaTokenExpiration($github_pa_token_expiration);
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
