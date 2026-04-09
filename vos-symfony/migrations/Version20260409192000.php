<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260409192000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set ON DELETE CASCADE for all foreign keys referencing utilisateur';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_1');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY offre_emploi_ibfk_1');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT offre_emploi_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE preference_candidature DROP FOREIGN KEY preference_candidature_ibfk_1');
        $this->addSql('ALTER TABLE preference_candidature ADD CONSTRAINT preference_candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY entretien_ibfk_2');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT entretien_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE recrutement DROP FOREIGN KEY recrutement_ibfk_2');
        $this->addSql('ALTER TABLE recrutement ADD CONSTRAINT recrutement_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY post_forum_ibfk_1');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT post_forum_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE commentaire_forum DROP FOREIGN KEY commentaire_forum_ibfk_2');
        $this->addSql('ALTER TABLE commentaire_forum ADD CONSTRAINT commentaire_forum_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE commentaire_forum DROP FOREIGN KEY commentaire_forum_ibfk_2');
        $this->addSql('ALTER TABLE commentaire_forum ADD CONSTRAINT commentaire_forum_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE post_forum DROP FOREIGN KEY post_forum_ibfk_1');
        $this->addSql('ALTER TABLE post_forum ADD CONSTRAINT post_forum_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE recrutement DROP FOREIGN KEY recrutement_ibfk_2');
        $this->addSql('ALTER TABLE recrutement ADD CONSTRAINT recrutement_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY entretien_ibfk_2');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT entretien_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE preference_candidature DROP FOREIGN KEY preference_candidature_ibfk_1');
        $this->addSql('ALTER TABLE preference_candidature ADD CONSTRAINT preference_candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY offre_emploi_ibfk_1');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT offre_emploi_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');

        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_1');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
    }
}
