<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330113743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speciality_agent (speciality_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_F42FD6963B5A08D7 (speciality_id), INDEX IDX_F42FD6963414710B (agent_id), PRIMARY KEY(speciality_id, agent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speciality_agent ADD CONSTRAINT FK_F42FD6963B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_agent ADD CONSTRAINT FK_F42FD6963414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE speciality_agent');
    }
}
