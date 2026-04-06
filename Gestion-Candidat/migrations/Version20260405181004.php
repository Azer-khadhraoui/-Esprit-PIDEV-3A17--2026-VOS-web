<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260405181004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE commentaire_forum DROP FOREIGN KEY commentaire_forum_ibfk_2');
        $this->addSql('ALTER TABLE commentaire_forum DROP FOREIGN KEY commentaire_forum_ibfk_1');
        $this->addSql('ALTER TABLE contrat_embauche DROP FOREIGN KEY contrat_embauche_ibfk_1');
        $this->addSql('ALTER TABLE critere_offre DROP FOREIGN KEY critere_offre_ibfk_1');
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY entretien_ibfk_1');
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY entretien_ibfk_2');
        $this->addSql('ALTER TABLE evaluation_entretien DROP FOREIGN KEY evaluation_entretien_ibfk_1');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY offre_emploi_ibfk_1');
        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY post_forum_ibfk_1');
        $this->addSql('ALTER TABLE recrutement DROP FOREIGN KEY recrutement_ibfk_1');
        $this->addSql('ALTER TABLE recrutement DROP FOREIGN KEY recrutement_ibfk_2');
        $this->addSql('DROP TABLE commentaire_forum');
        $this->addSql('DROP TABLE contrat_embauche');
        $this->addSql('DROP TABLE critere_offre');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE evaluation_entretien');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE post_forum');
        $this->addSql('DROP TABLE recrutement');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_1');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_2');
        $this->addSql('DROP INDEX id_utilisateur ON candidature');
        $this->addSql('DROP INDEX id_offre ON candidature');
        $this->addSql('ALTER TABLE candidature CHANGE message_candidat message_candidat LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE preference_candidature DROP FOREIGN KEY preference_candidature_ibfk_1');
        $this->addSql('DROP INDEX id_utilisateur ON preference_candidature');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_forum (id_commentaire INT AUTO_INCREMENT NOT NULL, contenu TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_commentaire DATE DEFAULT NULL, id_post INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, INDEX id_post (id_post), INDEX id_utilisateur (id_utilisateur), PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contrat_embauche (id_contrat INT AUTO_INCREMENT NOT NULL, type_contrat VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, salaire DOUBLE PRECISION DEFAULT NULL, status ENUM(\'Actif\', \'Terminé\', \'En attente\', \'Annulé\') CHARACTER SET utf8mb4 DEFAULT \'En attente\' COLLATE `utf8mb4_general_ci`, volume_horaire VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'35h\' COLLATE `utf8mb4_general_ci`, avantages TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_recrutement INT DEFAULT NULL, periode VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'\' COLLATE `utf8mb4_general_ci`, INDEX id_recrutement (id_recrutement), PRIMARY KEY(id_contrat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE critere_offre (id_critere INT AUTO_INCREMENT NOT NULL, niveau_experience VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, niveau_etude VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, competences_requises TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, responsibilities VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_offre INT DEFAULT NULL, INDEX id_offre (id_offre), PRIMARY KEY(id_critere)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE entretien (id_entretien INT AUTO_INCREMENT NOT NULL, date_entretien DATE DEFAULT NULL, heure_entretien TIME DEFAULT NULL, type_entretien ENUM(\'RH\', \'TECHNIQUE\') CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, statut_entretien VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, type_test VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, questions_entretien TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, lien_reunion VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_candidature INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, INDEX id_candidature (id_candidature), INDEX id_utilisateur (id_utilisateur), PRIMARY KEY(id_entretien)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evaluation_entretien (id_evaluation INT AUTO_INCREMENT NOT NULL, score_test DOUBLE PRECISION DEFAULT NULL, note_entretien INT DEFAULT NULL, commentaire TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, decision VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_entretien INT DEFAULT NULL, competences_techniques INT DEFAULT 0, competences_comportementales INT DEFAULT 0, communication INT DEFAULT 0, motivation INT DEFAULT 0, experience INT DEFAULT 0, INDEX id_entretien (id_entretien), PRIMARY KEY(id_evaluation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre_emploi (id_offre INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, type_contrat VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, statut_offre VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_publication DATE DEFAULT NULL, id_utilisateur INT DEFAULT NULL, work_preference VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, lieu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, INDEX id_utilisateur (id_utilisateur), PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE post_forum (id_post INT AUTO_INCREMENT NOT NULL, titre VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, contenu TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, date_creation DATE DEFAULT NULL, categorie VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_utilisateur INT DEFAULT NULL, INDEX id_utilisateur (id_utilisateur), PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recrutement (id_recrutement INT AUTO_INCREMENT NOT NULL, date_decision DATE DEFAULT NULL, decision_finale VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, id_entretien INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, INDEX id_utilisateur (id_utilisateur), INDEX id_entretien (id_entretien), PRIMARY KEY(id_recrutement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT AUTO_INCREMENT NOT NULL, image_profil VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mot_de_passe VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role ENUM(\'CLIENT\', \'ADMIN_RH\', \'ADMIN_TECHNIQUE\') CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, signature_url VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX email (email), PRIMARY KEY(id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire_forum ADD CONSTRAINT commentaire_forum_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE commentaire_forum ADD CONSTRAINT commentaire_forum_ibfk_1 FOREIGN KEY (id_post) REFERENCES post_forum (id_post)');
        $this->addSql('ALTER TABLE contrat_embauche ADD CONSTRAINT contrat_embauche_ibfk_1 FOREIGN KEY (id_recrutement) REFERENCES recrutement (id_recrutement)');
        $this->addSql('ALTER TABLE critere_offre ADD CONSTRAINT critere_offre_ibfk_1 FOREIGN KEY (id_offre) REFERENCES offre_emploi (id_offre)');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT entretien_ibfk_1 FOREIGN KEY (id_candidature) REFERENCES candidature (id_candidature)');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT entretien_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE evaluation_entretien ADD CONSTRAINT evaluation_entretien_ibfk_1 FOREIGN KEY (id_entretien) REFERENCES entretien (id_entretien)');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT offre_emploi_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT post_forum_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE recrutement ADD CONSTRAINT recrutement_ibfk_1 FOREIGN KEY (id_entretien) REFERENCES entretien (id_entretien)');
        $this->addSql('ALTER TABLE recrutement ADD CONSTRAINT recrutement_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE candidature CHANGE message_candidat message_candidat TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_2 FOREIGN KEY (id_offre) REFERENCES offre_emploi (id_offre)');
        $this->addSql('CREATE INDEX id_utilisateur ON candidature (id_utilisateur)');
        $this->addSql('CREATE INDEX id_offre ON candidature (id_offre)');
        $this->addSql('ALTER TABLE preference_candidature ADD CONSTRAINT preference_candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('CREATE INDEX id_utilisateur ON preference_candidature (id_utilisateur)');
    }
}
