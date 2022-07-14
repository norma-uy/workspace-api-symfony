<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714125809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE github_user ADD login VARCHAR(255) NOT NULL, ADD node_id VARCHAR(255) NOT NULL, ADD gravatar_id VARCHAR(255) DEFAULT NULL, ADD url VARCHAR(255) NOT NULL, ADD followers_url VARCHAR(255) NOT NULL, ADD following_url VARCHAR(255) NOT NULL, ADD gists_url VARCHAR(255) NOT NULL, ADD starred_url VARCHAR(255) NOT NULL, ADD subscriptions_url VARCHAR(255) NOT NULL, ADD organizations_url VARCHAR(255) NOT NULL, ADD repos_url VARCHAR(255) NOT NULL, ADD events_url VARCHAR(255) NOT NULL, ADD received_events_url VARCHAR(255) NOT NULL, ADD site_admin TINYINT(1) NOT NULL, ADD company VARCHAR(255) DEFAULT NULL, ADD blog VARCHAR(255) DEFAULT NULL, ADD location VARCHAR(255) NOT NULL, ADD hireable TINYINT(1) NOT NULL, ADD bio VARCHAR(255) DEFAULT NULL, ADD twitter_username VARCHAR(255) DEFAULT NULL, ADD public_gists INT NOT NULL, ADD followers INT NOT NULL, ADD following INT NOT NULL, ADD private_gists INT NOT NULL, ADD total_private_repos INT NOT NULL, ADD owned_private_repos INT NOT NULL, ADD disk_usage INT NOT NULL, ADD collaborators INT NOT NULL, ADD two_factor_authentication TINYINT(1) NOT NULL, ADD plan LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE github_user DROP login, DROP node_id, DROP gravatar_id, DROP url, DROP followers_url, DROP following_url, DROP gists_url, DROP starred_url, DROP subscriptions_url, DROP organizations_url, DROP repos_url, DROP events_url, DROP received_events_url, DROP site_admin, DROP company, DROP blog, DROP location, DROP hireable, DROP bio, DROP twitter_username, DROP public_gists, DROP followers, DROP following, DROP private_gists, DROP total_private_repos, DROP owned_private_repos, DROP disk_usage, DROP collaborators, DROP two_factor_authentication, DROP plan');
    }
}
