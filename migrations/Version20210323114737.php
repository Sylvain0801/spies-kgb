<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323114737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent ADD nationality_id INT NOT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D1C9DA55 FOREIGN KEY (nationality_id) REFERENCES nationality (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9D1C9DA55 ON agent (nationality_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D1C9DA55');
        $this->addSql('DROP INDEX IDX_268B9C9D1C9DA55 ON agent');
        $this->addSql('ALTER TABLE agent DROP nationality_id');
    }
}
