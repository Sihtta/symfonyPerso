<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241028132157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Création de la table 'outil' au lieu de 'ingredient'
        $this->addSql('CREATE TABLE outil (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            description VARCHAR(250) NOT NULL, 
            reference VARCHAR(250) NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Création de la table 'recipe_outil' pour lier les recettes aux outils
        $this->addSql('CREATE TABLE recipe_outil (
            recipe_id INT NOT NULL, 
            outil_id INT NOT NULL, 
            INDEX IDX_22D1FE1359D8A214 (recipe_id), 
            INDEX IDX_22D1FE13933FE08C (outil_id), 
            PRIMARY KEY(recipe_id, outil_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Ajout des clés étrangères pour la table 'recipe_outil'
        $this->addSql('ALTER TABLE recipe_outil 
            ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_outil 
            ADD CONSTRAINT FK_22D1FE13933FE08C FOREIGN KEY (outil_id) REFERENCES outil (id) ON DELETE CASCADE');

        // Modification de la table 'recipe' si nécessaire
        // Pas de modification nécessaire ici
    }

    public function down(Schema $schema): void
    {
        // Suppression des clés étrangères
        $this->addSql('ALTER TABLE recipe_outil DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_outil DROP FOREIGN KEY FK_22D1FE13933FE08C');

        // Suppression des tables 'outil' et 'recipe_outil'
        $this->addSql('DROP TABLE outil');
        $this->addSql('DROP TABLE recipe_outil');

        // Restauration de la table 'ingredient' dans son état initial
        $this->addSql('CREATE TABLE ingredient (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            price DOUBLE PRECISION NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }
}
