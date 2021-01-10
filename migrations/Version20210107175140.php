<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210107175140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA779F37AE5');
        $this->addSql('DROP INDEX IDX_3BAE0AA779F37AE5 ON event');
        $this->addSql('ALTER TABLE event CHANGE player_1 player_1 INT DEFAULT NULL, CHANGE player_2 player_2 INT DEFAULT NULL, CHANGE player_3 player_3 INT DEFAULT NULL, CHANGE player_4 player_4 INT DEFAULT NULL, CHANGE id_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE phone phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A76ED395 ON event');
        $this->addSql('ALTER TABLE event CHANGE player_1 player_1 INT DEFAULT NULL, CHANGE player_2 player_2 INT DEFAULT NULL, CHANGE player_3 player_3 INT DEFAULT NULL, CHANGE player_4 player_4 INT DEFAULT NULL, CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA779F37AE5 ON event (id_user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
