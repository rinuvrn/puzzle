<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427072822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE TABLE puzzle (id INT AUTO_INCREMENT NOT NULL, puzzle_string VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("INSERT INTO `puzzle` (`id`, `puzzle_string`, `created_at`) VALUES ('1', 'iamrungocome', '2025-04-29 09:07:39')");
        $this->addSql("INSERT INTO `puzzle` (`id`, `puzzle_string`, `created_at`) VALUES (NULL, 'inastheforhim', '2025-04-29 09:50:56');");
        $this->addSql("CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, puzzle_id INT DEFAULT NULL, 
                       score DOUBLE PRECISION DEFAULT NULL, remaining_string VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, 
                       is_done SMALLINT NOT NULL, INDEX IDX_232B318CCB944F1A (student_id), INDEX IDX_232B318CD9816812 (puzzle_id), 
                       PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("ALTER TABLE game ADD CONSTRAINT FK_232B318CCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)");
        $this->addSql("ALTER TABLE game ADD CONSTRAINT FK_232B318CD9816812 FOREIGN KEY (puzzle_id) REFERENCES puzzle (id)");
        $this->addSql("ALTER TABLE grade CHANGE created_at created_at DATETIME NOT NULL");
        $this->addSql("CREATE TABLE words (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, word VARCHAR(255) NOT NULL,score DOUBLE PRECISION DEFAULT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_717D1E8CE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("ALTER TABLE words ADD CONSTRAINT FK_717D1E8CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE puzzle");
        $this->addSql("DROP TABLE student");
        $this->addSql("DROP TABLE messenger_messages");
        $this->addSql("ALTER TABLE game DROP FOREIGN KEY FK_232B318CCB944F1A");
        $this->addSql("ALTER TABLE game DROP FOREIGN KEY FK_232B318CD9816812");
        $this->addSql("DROP TABLE game");
        $this->addSql("ALTER TABLE words DROP FOREIGN KEY FK_717D1E8CE48FD905");
        $this->addSql("DROP TABLE words");
    }
}
