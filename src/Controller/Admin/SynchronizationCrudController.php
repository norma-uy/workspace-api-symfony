<?php

namespace App\Controller\Admin;

use App\Entity\GithubOrganization;
use App\Entity\GithubUser;
use App\Entity\Synchronization;
use App\Entity\User;
use App\Utility\GithubAPI;
use App\Utility\GithubDataSync;
use App\Utility\GithubUtility;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

#[IsGranted('ROLE_SUPER_ADMIN')]
class SynchronizationCrudController extends AbstractCrudController
{
    public function __construct(
        private GithubDataSync $githubDataSync,
        private GithubAPI $githubApi,
        private Security $security,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Synchronization::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the visible title at the top of the page and the content of the <title> element
            // it can include these placeholders:
            //   %entity_name%, %entity_as_string%,
            //   %entity_id%, %entity_short_id%
            //   %entity_label_singular%, %entity_label_plural%
            ->setPageTitle('index', 'Listado - Sincronización');

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
            DateTimeField::new('create_date', 'Fecha de creación')->hideOnForm(),
            AssociationField::new('author', 'Creado por')
                ->hideOnForm()
                ->autocomplete(),
            ChoiceField::new('synchronized_entity', 'Entidad')
                ->setChoices(
                    fn() => [
                        'Usuario' => GithubUser::class,
                        'Organización' => GithubOrganization::class,
                    ],
                )
                ->hideOnIndex()
                ->hideWhenUpdating(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::DELETE, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function createEntity(string $entityFqcn)
    {
        return new $entityFqcn();
    }

    /**
     * Undocumented function
     *
     * @param EntityManagerInterface $entityManager
     * @param Synchronization $entityInstance
     * @return void
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /**
         * @var User $current_user
         */
        $current_user = $this->security->getUser();

        $entityInstance->setCreatedAt(new DateTimeImmutable('now'));
        $entityInstance->setUpdatedAt(new DateTimeImmutable('now'));
        $entityInstance->setAuthor($current_user);

        $github_pa_token = $current_user->getGithubPaToken();

        switch ($entityInstance->getSynchronizedEntity()) {
            case GithubUser::class:
                //github user synchronization

                $github_username = $current_user->getGithubUsername();

                $response = $this->githubApi->getUser($github_pa_token, $github_username);

                if ($response) {
                    //get github scopes
                    $x_oauth_scopes = GithubUtility::HeaderScopesDecode(
                        $response->getHeaderLine('X-OAuth-Scopes'),
                    );

                    //get body request
                    $body = json_decode($response->getBody(), true);

                    if (!empty($x_oauth_scopes) && !empty($body) && isset($body['id'])) {
                        $githubUser = $this->githubDataSync->userSync($body);

                        $entityManager->persist($githubUser);
                        $current_user->setGithubUser($githubUser);

                        $entityInstance->setSynchronizedData($body);
                    }

                    //saving scopes
                    $current_user->setGithubPaTokenScope($x_oauth_scopes);

                    //Token expiration
                    $github_pa_token_expiration = $response->getHeaderLine(
                        'github-authentication-token-expiration',
                    );
                    $github_pa_token_expiration = $github_pa_token_expiration
                        ? new \DateTimeImmutable($github_pa_token_expiration)
                        : null;
                    $current_user->setGithubPaTokenExpiration($github_pa_token_expiration);
                }

                break;

            case GithubOrganization::class:
                //github organization synchronization

                $orgs_response = $this->githubApi->getOrganizationByAuthenticatedUser(
                    $github_pa_token,
                );

                if ($orgs_response) {
                    //get github scopes
                    $orgs_x_oauth_scopes = GithubUtility::HeaderScopesDecode(
                        $orgs_response->getHeaderLine('X-OAuth-Scopes'),
                    );

                    $orgs_body = json_decode($orgs_response->getBody(), true);

                    if (
                        !empty($orgs_x_oauth_scopes) &&
                        !empty($orgs_body) &&
                        count($orgs_body) > 0
                    ) {
                        foreach ($orgs_body as $i_org => $org_body) {
                            $org_response = $this->githubApi->getOrganization(
                                $github_pa_token,
                                $org_body['login'],
                            );

                            if ($org_response) {
                                //get github scopes
                                $org_x_oauth_scopes = GithubUtility::HeaderScopesDecode(
                                    $org_response->getHeaderLine('X-OAuth-Scopes'),
                                );

                                $org_body = json_decode($org_response->getBody(), true);

                                if (
                                    !empty($org_x_oauth_scopes) &&
                                    !empty($org_body) &&
                                    count($org_body) > 0
                                ) {
                                    $githubOrganization = $this->githubDataSync->organizationSync(
                                        $org_body,
                                    );

                                    $githubOrganization->addMember($current_user->getGithubUser());

                                    $entityManager->persist($githubOrganization);
                                }
                            }
                        }

                        $entityInstance->setSynchronizedData($orgs_body);
                    }

                    //saving scopes
                    $current_user->setGithubPaTokenScope($orgs_x_oauth_scopes);

                    //Token expiration
                    $github_pa_token_expiration = $orgs_response->getHeaderLine(
                        'github-authentication-token-expiration',
                    );
                    $github_pa_token_expiration = $github_pa_token_expiration
                        ? new \DateTimeImmutable($github_pa_token_expiration)
                        : null;
                    $current_user->setGithubPaTokenExpiration($github_pa_token_expiration);
                }
                break;
        }

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
