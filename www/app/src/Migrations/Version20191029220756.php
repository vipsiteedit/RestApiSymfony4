<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029220756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ligues DROP FOREIGN KEY ligues_ibfk_1');
        $this->addSql('DROP INDEX sports_id ON ligues');
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY teams_ibfk_1');
        $this->addSql('DROP INDEX ligues_id ON teams');
        $this->addSql('DROP INDEX hash ON game_buffer');
        $this->addSql('ALTER TABLE game_buffer CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE lang lang VARCHAR(40) NOT NULL, CHANGE sport sport VARCHAR(255) NOT NULL, CHANGE ligue ligue VARCHAR(255) NOT NULL, CHANGE team1 team1 VARCHAR(255) NOT NULL, CHANGE team2 team2 VARCHAR(255) NOT NULL, CHANGE start_game start_game VARCHAR(40) NOT NULL, CHANGE source_info source_info VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE params DROP FOREIGN KEY params_ibfk_1');
        $this->addSql('ALTER TABLE params DROP FOREIGN KEY params_ibfk_2');
        $this->addSql('ALTER TABLE params DROP FOREIGN KEY params_ibfk_3');
        $this->addSql('ALTER TABLE params DROP FOREIGN KEY params_ibfk_4');
        $this->addSql('DROP INDEX teams_id ON params');
        $this->addSql('DROP INDEX ligues_id ON params');
        $this->addSql('DROP INDEX name ON params');
        $this->addSql('DROP INDEX sports_id ON params');
        $this->addSql('DROP INDEX langs_id ON params');
        $this->addSql('ALTER TABLE params CHANGE sports_id sports_id INT DEFAULT NULL, CHANGE ligues_id ligues_id INT DEFAULT NULL, CHANGE teams_id teams_id INT DEFAULT NULL, CHANGE langs_id langs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY game_ibfk_1');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY game_ibfk_2');
        $this->addSql('DROP INDEX teams2_id ON game');
        $this->addSql('DROP INDEX games_unique ON game');
        $this->addSql('DROP INDEX teams1_id ON game');
        $this->addSql('ALTER TABLE game CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT game_ibfk_1 FOREIGN KEY (teams1_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT game_ibfk_2 FOREIGN KEY (teams2_id) REFERENCES teams (id)');
        $this->addSql('CREATE INDEX teams2_id ON game (teams2_id)');
        $this->addSql('CREATE UNIQUE INDEX games_unique ON game (teams1_id, teams2_id, game_time)');
        $this->addSql('CREATE INDEX teams1_id ON game (teams1_id)');
        $this->addSql('ALTER TABLE game_buffer CHANGE id id BIGINT AUTO_INCREMENT NOT NULL, CHANGE lang lang VARCHAR(40) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE sport sport VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE ligue ligue VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE team1 team1 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE team2 team2 VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE start_game start_game VARCHAR(40) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE source_info source_info VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX hash ON game_buffer (hash)');
        $this->addSql('ALTER TABLE ligues ADD CONSTRAINT ligues_ibfk_1 FOREIGN KEY (sports_id) REFERENCES sports (id)');
        $this->addSql('CREATE INDEX sports_id ON ligues (sports_id)');
        $this->addSql('ALTER TABLE params CHANGE sports_id sports_id INT DEFAULT NULL, CHANGE ligues_id ligues_id INT DEFAULT NULL, CHANGE teams_id teams_id INT DEFAULT NULL, CHANGE langs_id langs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE params ADD CONSTRAINT params_ibfk_1 FOREIGN KEY (langs_id) REFERENCES langs (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE params ADD CONSTRAINT params_ibfk_2 FOREIGN KEY (ligues_id) REFERENCES ligues (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE params ADD CONSTRAINT params_ibfk_3 FOREIGN KEY (sports_id) REFERENCES sports (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE params ADD CONSTRAINT params_ibfk_4 FOREIGN KEY (teams_id) REFERENCES teams (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX teams_id ON params (teams_id)');
        $this->addSql('CREATE INDEX ligues_id ON params (ligues_id)');
        $this->addSql('CREATE INDEX name ON params (name)');
        $this->addSql('CREATE INDEX sports_id ON params (sports_id)');
        $this->addSql('CREATE INDEX langs_id ON params (langs_id)');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT teams_ibfk_1 FOREIGN KEY (ligues_id) REFERENCES ligues (id)');
        $this->addSql('CREATE INDEX ligues_id ON teams (ligues_id)');
    }
}
