<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315135152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marvel_comic (marvel_id INT NOT NULL, comic_id INT NOT NULL, INDEX IDX_99EE6D5048CA5102 (marvel_id), INDEX IDX_99EE6D50D663094A (comic_id), PRIMARY KEY(marvel_id, comic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marvel_serie (marvel_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_68AA5BCE48CA5102 (marvel_id), INDEX IDX_68AA5BCED94388BD (serie_id), PRIMARY KEY(marvel_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marvel_storie (marvel_id INT NOT NULL, storie_id INT NOT NULL, INDEX IDX_D05B0D5B48CA5102 (marvel_id), INDEX IDX_D05B0D5B3DF3EA3D (storie_id), PRIMARY KEY(marvel_id, storie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marvel_event (marvel_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_F93EC25D48CA5102 (marvel_id), INDEX IDX_F93EC25D71F7E88B (event_id), PRIMARY KEY(marvel_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marvel_comic ADD CONSTRAINT FK_99EE6D5048CA5102 FOREIGN KEY (marvel_id) REFERENCES marvel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_comic ADD CONSTRAINT FK_99EE6D50D663094A FOREIGN KEY (comic_id) REFERENCES comic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_serie ADD CONSTRAINT FK_68AA5BCE48CA5102 FOREIGN KEY (marvel_id) REFERENCES marvel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_serie ADD CONSTRAINT FK_68AA5BCED94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_storie ADD CONSTRAINT FK_D05B0D5B48CA5102 FOREIGN KEY (marvel_id) REFERENCES marvel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_storie ADD CONSTRAINT FK_D05B0D5B3DF3EA3D FOREIGN KEY (storie_id) REFERENCES storie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_event ADD CONSTRAINT FK_F93EC25D48CA5102 FOREIGN KEY (marvel_id) REFERENCES marvel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel_event ADD CONSTRAINT FK_F93EC25D71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE5278319C');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE71AE76A2');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBE9D6A1065');
        $this->addSql('ALTER TABLE marvel DROP FOREIGN KEY FK_6C3E2DBEBF2402DE');
        $this->addSql('DROP INDEX IDX_6C3E2DBE5278319C ON marvel');
        $this->addSql('DROP INDEX IDX_6C3E2DBE71AE76A2 ON marvel');
        $this->addSql('DROP INDEX IDX_6C3E2DBE9D6A1065 ON marvel');
        $this->addSql('DROP INDEX IDX_6C3E2DBEBF2402DE ON marvel');
        $this->addSql('ALTER TABLE marvel DROP comics_id, DROP series_id, DROP stories_id, DROP events_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marvel_comic DROP FOREIGN KEY FK_99EE6D5048CA5102');
        $this->addSql('ALTER TABLE marvel_comic DROP FOREIGN KEY FK_99EE6D50D663094A');
        $this->addSql('ALTER TABLE marvel_serie DROP FOREIGN KEY FK_68AA5BCE48CA5102');
        $this->addSql('ALTER TABLE marvel_serie DROP FOREIGN KEY FK_68AA5BCED94388BD');
        $this->addSql('ALTER TABLE marvel_storie DROP FOREIGN KEY FK_D05B0D5B48CA5102');
        $this->addSql('ALTER TABLE marvel_storie DROP FOREIGN KEY FK_D05B0D5B3DF3EA3D');
        $this->addSql('ALTER TABLE marvel_event DROP FOREIGN KEY FK_F93EC25D48CA5102');
        $this->addSql('ALTER TABLE marvel_event DROP FOREIGN KEY FK_F93EC25D71F7E88B');
        $this->addSql('DROP TABLE marvel_comic');
        $this->addSql('DROP TABLE marvel_serie');
        $this->addSql('DROP TABLE marvel_storie');
        $this->addSql('DROP TABLE marvel_event');
        $this->addSql('ALTER TABLE marvel ADD comics_id INT DEFAULT NULL, ADD series_id INT DEFAULT NULL, ADD stories_id INT DEFAULT NULL, ADD events_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE5278319C FOREIGN KEY (series_id) REFERENCES serie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE71AE76A2 FOREIGN KEY (comics_id) REFERENCES comic (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBE9D6A1065 FOREIGN KEY (events_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE marvel ADD CONSTRAINT FK_6C3E2DBEBF2402DE FOREIGN KEY (stories_id) REFERENCES storie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6C3E2DBE5278319C ON marvel (series_id)');
        $this->addSql('CREATE INDEX IDX_6C3E2DBE71AE76A2 ON marvel (comics_id)');
        $this->addSql('CREATE INDEX IDX_6C3E2DBE9D6A1065 ON marvel (events_id)');
        $this->addSql('CREATE INDEX IDX_6C3E2DBEBF2402DE ON marvel (stories_id)');
    }
}
