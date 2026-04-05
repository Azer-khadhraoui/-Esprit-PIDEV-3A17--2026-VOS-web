<?php

namespace App\Entity;

use App\Repository\PreferenceCandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceCandidatureRepository::class)]
class PreferenceCandidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $type_poste_souhaite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mode_travail = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $disponibilite = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mobilite_geographique = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pret_deplacement = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type_contrat_souhaite = null;

    #[ORM\Column(nullable: true)]
    private ?float $pretention_salariale = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_disponibilite = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePosteSouhaite(): ?string
    {
        return $this->type_poste_souhaite;
    }

    public function setTypePosteSouhaite(?string $type_poste_souhaite): static
    {
        $this->type_poste_souhaite = $type_poste_souhaite;

        return $this;
    }

    public function getModeTravail(): ?string
    {
        return $this->mode_travail;
    }

    public function setModeTravail(?string $mode_travail): static
    {
        $this->mode_travail = $mode_travail;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getMobiliteGeographique(): ?string
    {
        return $this->mobilite_geographique;
    }

    public function setMobiliteGeographique(?string $mobilite_geographique): static
    {
        $this->mobilite_geographique = $mobilite_geographique;

        return $this;
    }

    public function getPretDeplacement(): ?string
    {
        return $this->pret_deplacement;
    }

    public function setPretDeplacement(?string $pret_deplacement): static
    {
        $this->pret_deplacement = $pret_deplacement;

        return $this;
    }

    public function getTypeContratSouhaite(): ?string
    {
        return $this->type_contrat_souhaite;
    }

    public function setTypeContratSouhaite(?string $type_contrat_souhaite): static
    {
        $this->type_contrat_souhaite = $type_contrat_souhaite;

        return $this;
    }

    public function getPretentionSalariale(): ?float
    {
        return $this->pretention_salariale;
    }

    public function setPretentionSalariale(?float $pretention_salariale): static
    {
        $this->pretention_salariale = $pretention_salariale;

        return $this;
    }

    public function getDateDisponibilite(): ?\DateTime
    {
        return $this->date_disponibilite;
    }

    public function setDateDisponibilite(?\DateTime $date_disponibilite): static
    {
        $this->date_disponibilite = $date_disponibilite;

        return $this;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?int $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }
}
