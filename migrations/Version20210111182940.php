<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111182940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, player_1_id INT NOT NULL, player_2_id INT DEFAULT NULL, player_3_id INT DEFAULT NULL, player_4_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, level VARCHAR(2) NOT NULL, created_date DATE NOT NULL, INDEX IDX_3BAE0AA752C90CC9 (player_1_id), INDEX IDX_3BAE0AA7407CA327 (player_2_id), INDEX IDX_3BAE0AA7F8C0C442 (player_3_id), INDEX IDX_3BAE0AA76517FCFB (player_4_id), INDEX IDX_3BAE0AA7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_banned TINYINT(1) NOT NULL, phone VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, register_date DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA752C90CC9 FOREIGN KEY (player_1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7407CA327 FOREIGN KEY (player_2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F8C0C442 FOREIGN KEY (player_3_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76517FCFB FOREIGN KEY (player_4_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA752C90CC9');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7407CA327');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7F8C0C442');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76517FCFB');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE user');
    }
}
