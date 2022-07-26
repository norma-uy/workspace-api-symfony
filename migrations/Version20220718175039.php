<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718175039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE members (github_user_id INT NOT NULL, github_organization_id INT NOT NULL, INDEX IDX_45A0D2FFA8674B11 (github_user_id), INDEX IDX_45A0D2FF9CC1D6BC (github_organization_id), PRIMARY KEY(github_user_id, github_organization_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE members ADD CONSTRAINT FK_45A0D2FFA8674B11 FOREIGN KEY (github_user_id) REFERENCES github_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE members ADD CONSTRAINT FK_45A0D2FF9CC1D6BC FOREIGN KEY (github_organization_id) REFERENCES github_organization (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE members');
    }
}
