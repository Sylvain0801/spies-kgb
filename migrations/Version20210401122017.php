<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401122017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638BE6CAE90');
        $this->addSql('DROP INDEX IDX_4C62E638BE6CAE90 ON contact');
        $this->addSql('ALTER TABLE contact DROP mission_id');
        $this->addSql('ALTER TABLE hideout DROP FOREIGN KEY FK_2C2FE159BE6CAE90');
        $this->addSql('DROP INDEX IDX_2C2FE159BE6CAE90 ON hideout');
        $this->addSql('ALTER TABLE hideout DROP mission_id');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCBE6CAE90');
        $this->addSql('DROP INDEX IDX_466F2FFCBE6CAE90 ON target');
        $this->addSql('ALTER TABLE target DROP mission_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638BE6CAE90 ON contact (mission_id)');
        $this->addSql('ALTER TABLE hideout ADD mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hideout ADD CONSTRAINT FK_2C2FE159BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_2C2FE159BE6CAE90 ON hideout (mission_id)');
        $this->addSql('ALTER TABLE target ADD mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_466F2FFCBE6CAE90 ON target (mission_id)');
    }
}
