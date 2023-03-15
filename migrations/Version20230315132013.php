<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315132013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comic (id INT AUTO_INCREMENT NOT NULL, resource_uri VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, resource_uri VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marvel (id INT AUTO_INCREMENT NOT NULL, comics_id INT DEFAULT NULL, series_id INT DEFAULT NULL, stories_id INT DEFAULT NULL, events_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, modified DATETIME NOT NULL, thumbnail VARCHAR(255) DEFAULT NULL, resource_uri VARCHAR(255) DEFAULT NULL, INDEX IDX_6C3E2DBE71AE76A2 (comics_id), INDEX IDX_6C3E2DBE5278319C (series_id), INDEX IDX_6C3E2DBEBF2402DE (stories_id), INDEX IDX_6C3E2DBE9D6A1065 (events_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, resource_uri VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE storie (id INT AUTO_INCREMENT NOT NULL, resource_uri VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE71AE76A2 FOREIGN KEY (comics_id) REFERENCES comic (id)');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE5278319C FOREIGN KEY (series_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBEBF2402DE FOREIGN KEY (stories_id) REFERENCES storie (id)');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE9D6A1065 FOREIGN KEY (events_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE71AE76A2');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE5278319C');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBEBF2402DE');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE9D6A1065');
        $this->addSql('DROP TABLE comic');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE marvel');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE storie');
        $this->addSql('DROP TABLE user');
    }
}
