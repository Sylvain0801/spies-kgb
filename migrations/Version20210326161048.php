<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326161048 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hideout DROP FOREIGN KEY FK_2C2FE159F92F3E70');
        $this->addSql('DROP INDEX IDX_2C2FE159F92F3E70 ON hideout');
        $this->addSql('ALTER TABLE hideout CHANGE country_id nationality_id INT NOT NULL');
        $this->addSql('ALTER TABLE hideout ADD CONSTRAINT FK_2C2FE1591C9DA55 FOREIGN KEY (nationality_id) REFERENCES nationality (id)');
        $this->addSql('CREATE INDEX IDX_2C2FE1591C9DA55 ON hideout (nationality_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hideout DROP FOREIGN KEY FK_2C2FE1591C9DA55');
        $this->addSql('DROP INDEX IDX_2C2FE1591C9DA55 ON hideout');
        $this->addSql('ALTER TABLE hideout CHANGE nationality_id country_id INT NOT NULL');
        $this->addSql('ALTER TABLE hideout ADD CONSTRAINT FK_2C2FE159F92F3E70 FOREIGN KEY (country_id) REFERENCES nationality (id)');
        $this->addSql('CREATE INDEX IDX_2C2FE159F92F3E70 ON hideout (country_id)');
    }
}
