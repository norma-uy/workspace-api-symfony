<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715125750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE github_organization (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, github_id INT NOT NULL, node_id VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, repos_url VARCHAR(255) NOT NULL, events_url VARCHAR(255) NOT NULL, hooks_url VARCHAR(255) NOT NULL, issues_url VARCHAR(255) NOT NULL, members_url VARCHAR(255) NOT NULL, public_members_url VARCHAR(255) NOT NULL, avatar_url VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, blog VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, twitter_username VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, has_organization_projects TINYINT(1) NOT NULL, has_repository_projects TINYINT(1) NOT NULL, public_repos INT NOT NULL, public_gists INT NOT NULL, followers INT NOT NULL, following INT NOT NULL, html_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', type VARCHAR(15) NOT NULL, total_private_repos INT NOT NULL, owned_private_repos INT NOT NULL, private_gists INT NOT NULL, disk_usage INT NOT NULL, collaborators INT NOT NULL, billing_email VARCHAR(255) NOT NULL, default_repository_permission VARCHAR(15) NOT NULL, members_can_create_repositories TINYINT(1) NOT NULL, two_factor_requirement_enabled TINYINT(1) NOT NULL, members_allowed_repository_creation_type VARCHAR(15) NOT NULL, members_can_create_public_repositories TINYINT(1) NOT NULL, members_can_create_private_repositories TINYINT(1) NOT NULL, members_can_create_internal_repositories TINYINT(1) NOT NULL, members_can_create_pages TINYINT(1) NOT NULL, members_can_fork_private_repositories TINYINT(1) NOT NULL, members_can_create_public_pages TINYINT(1) NOT NULL, members_can_create_private_pages TINYINT(1) NOT NULL, web_commit_signoff_required TINYINT(1) NOT NULL, plan JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, github_organization_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimetz_immutable)\', status SMALLINT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C1EE637C9CC1D6BC (github_organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C9CC1D6BC FOREIGN KEY (github_organization_id) REFERENCES github_organization (id)');
        $this->addSql('ALTER TABLE github_project ADD owner_url VARCHAR(255) NOT NULL, ADD url VARCHAR(255) NOT NULL, ADD html_url VARCHAR(255) NOT NULL, ADD columns_url VARCHAR(255) NOT NULL, ADD node_id VARCHAR(255) NOT NULL, ADD number INT NOT NULL, ADD creator JSON NOT NULL, ADD organization_permission VARCHAR(15) NOT NULL, ADD private TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C9CC1D6BC');
        $this->addSql('DROP TABLE github_organization');
        $this->addSql('DROP TABLE organization');
        $this->addSql('ALTER TABLE github_project DROP owner_url, DROP url, DROP html_url, DROP columns_url, DROP node_id, DROP number, DROP creator, DROP organization_permission, DROP private');
    }
}
