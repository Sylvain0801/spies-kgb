<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402115034 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9067F23C2B36786B6DE4402668C814C7 ON mission');
        $this->addSql('CREATE FULLTEXT INDEX IDX_9067F23C2B36786B6DE4402668C814C78CDE5729 ON mission (title, description, code_name, type)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_9067F23C2B36786B6DE4402668C814C78CDE5729 ON mission');
        $this->addSql('CREATE FULLTEXT INDEX IDX_9067F23C2B36786B6DE4402668C814C7 ON mission (title, description, code_name)');
    }
}
