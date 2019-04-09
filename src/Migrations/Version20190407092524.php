<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190407092524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cra (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, date DATE NOT NULL, journee VARCHAR(255) NOT NULL, INDEX IDX_926CE6D119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, date DATE NOT NULL, type VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, date DATE NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, etat VARCHAR(255) NOT NULL, designation LONGTEXT NOT NULL, quantite DOUBLE PRECISION NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, total_ht DOUBLE PRECISION DEFAULT NULL, total_tva DOUBLE PRECISION DEFAULT NULL, total_ttc DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FE86641019EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frais (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, libelle VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, montant_ttc DOUBLE PRECISION NOT NULL, montant_ht DOUBLE PRECISION NOT NULL, justificatif VARCHAR(255) NOT NULL, taxe DOUBLE PRECISION NOT NULL, etat VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, numero_siret VARCHAR(255) NOT NULL, tva_intercomunaitaire VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', etat TINYINT(1) DEFAULT \'1\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cra ADD CONSTRAINT FK_926CE6D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cra DROP FOREIGN KEY FK_926CE6D119EB6921');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641019EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE cra');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE frais');
        $this->addSql('DROP TABLE societe');
        $this->addSql('DROP TABLE utilisateur');
    }
}
