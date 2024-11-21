<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121151706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(250) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creation_tool (creation_id INT NOT NULL, tool_id INT NOT NULL, INDEX IDX_FD8578F534FFA69A (creation_id), INDEX IDX_FD8578F58F7B22CC (tool_id), PRIMARY KEY(creation_id, tool_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creation_category (creation_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_DC0CA0C334FFA69A (creation_id), INDEX IDX_DC0CA0C312469DE2 (category_id), PRIMARY KEY(creation_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(250) DEFAULT NULL, reference VARCHAR(250) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creation_tool ADD CONSTRAINT FK_FD8578F534FFA69A FOREIGN KEY (creation_id) REFERENCES creation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creation_tool ADD CONSTRAINT FK_FD8578F58F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creation_category ADD CONSTRAINT FK_DC0CA0C334FFA69A FOREIGN KEY (creation_id) REFERENCES creation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creation_category ADD CONSTRAINT FK_DC0CA0C312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` ADD creation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B334FFA69A FOREIGN KEY (creation_id) REFERENCES creation (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B334FFA69A ON `like` (creation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B334FFA69A');
        $this->addSql('ALTER TABLE creation_tool DROP FOREIGN KEY FK_FD8578F534FFA69A');
        $this->addSql('ALTER TABLE creation_tool DROP FOREIGN KEY FK_FD8578F58F7B22CC');
        $this->addSql('ALTER TABLE creation_category DROP FOREIGN KEY FK_DC0CA0C334FFA69A');
        $this->addSql('ALTER TABLE creation_category DROP FOREIGN KEY FK_DC0CA0C312469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE creation');
        $this->addSql('DROP TABLE creation_tool');
        $this->addSql('DROP TABLE creation_category');
        $this->addSql('DROP TABLE tool');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('DROP INDEX IDX_AC6340B334FFA69A ON `like`');
        $this->addSql('ALTER TABLE `like` DROP creation_id');
    }
}
