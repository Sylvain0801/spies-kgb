<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327110606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, nationality_id INT NOT NULL, statute_id INT NOT NULL, title VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, code_name VARCHAR(45) NOT NULL, type VARCHAR(128) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_9067F23C1C9DA55 (nationality_id), INDEX IDX_9067F23C95985147 (statute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C1C9DA55 FOREIGN KEY (nationality_id) REFERENCES nationality (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C95985147 FOREIGN KEY (statute_id) REFERENCES statute (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE mission');
    }
}
