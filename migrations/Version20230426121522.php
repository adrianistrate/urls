<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426121522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE webpage (id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(255) NOT NULL, pathname VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webpage_parameter (id INT AUTO_INCREMENT NOT NULL, webpage_id INT DEFAULT NULL, parameter VARCHAR(255) NOT NULL, INDEX IDX_E4ABB07EE20F2920 (webpage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE webpage_parameter ADD CONSTRAINT FK_E4ABB07EE20F2920 FOREIGN KEY (webpage_id) REFERENCES webpage (id)');
        $this->addSql('ALTER TABLE domain_list CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE domain domain VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE webpage_parameter DROP FOREIGN KEY FK_E4ABB07EE20F2920');
        $this->addSql('DROP TABLE webpage');
        $this->addSql('DROP TABLE webpage_parameter');
        $this->addSql('ALTER TABLE domain_list CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE domain domain VARCHAR(255) DEFAULT NULL');
    }
}
