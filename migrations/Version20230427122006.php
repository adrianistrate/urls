<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427122006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE webpage CHANGE domain domain VARCHAR(253) NOT NULL, CHANGE pathname pathname VARCHAR(1795) DEFAULT NULL');
        $this->addSql('CREATE INDEX domain_idx ON webpage (domain)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX domain_idx ON webpage');
        $this->addSql('ALTER TABLE webpage CHANGE domain domain VARCHAR(255) NOT NULL, CHANGE pathname pathname VARCHAR(255) DEFAULT NULL');
    }
}
