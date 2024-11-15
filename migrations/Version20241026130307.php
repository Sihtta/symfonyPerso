<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration pour la création de la table 'outil' tout en conservant d'autres tables
 */
final class Version20241026130307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table Outil avec ajustement des champs';
    }

    public function up(Schema $schema): void
    {
        // Création de la table 'outil' avec les champs spécifiés
        $this->addSql('CREATE TABLE outil (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            description VARCHAR(250) NOT NULL, 
            reference VARCHAR(250) NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Création de la table 'messenger_messages' (à conserver telle quelle)
        $this->addSql('CREATE TABLE messenger_messages (
            id BIGINT AUTO_INCREMENT NOT NULL, 
            body LONGTEXT NOT NULL, 
            headers LONGTEXT NOT NULL, 
            queue_name VARCHAR(190) NOT NULL, 
            created_at DATETIME NOT NULL, 
            available_at DATETIME NOT NULL, 
            delivered_at DATETIME DEFAULT NULL, 
            INDEX IDX_75EA56E0FB7336F0 (queue_name), 
            INDEX IDX_75EA56E0E3BD61CE (available_at), 
            INDEX IDX_75EA56E016BA31DB (delivered_at), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // Suppression de la table 'outil'
        $this->addSql('DROP TABLE outil');

        // Suppression de la table 'messenger_messages'
        $this->addSql('DROP TABLE messenger_messages');
    }
}
