<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427134844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX pathname_idx ON webpage');
        $this->addSql('CREATE INDEX pathname_idx ON webpage (pathname(768))');
        $this->addSql('DROP INDEX parameter_idx ON webpage_parameter');
        $this->addSql('ALTER TABLE webpage_parameter CHANGE parameter parameter VARCHAR(1785) DEFAULT NULL');
        $this->addSql('CREATE INDEX parameter_idx ON webpage_parameter (parameter(768))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX pathname_idx ON webpage');
        $this->addSql('CREATE INDEX pathname_idx ON webpage (pathname(768))');
        $this->addSql('DROP INDEX parameter_idx ON webpage_parameter');
        $this->addSql('ALTER TABLE webpage_parameter CHANGE parameter parameter VARCHAR(1788) DEFAULT NULL');
        $this->addSql('CREATE INDEX parameter_idx ON webpage_parameter (parameter(768))');
    }
}
