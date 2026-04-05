<?php

namespace App\Repository;

use App\Entity\Entretien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntretienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entretien::class);
    }

    public function findWithFilters(
        ?string $search = null,
        ?string $type = null,
        ?string $statut = null,
        string $sortBy = 'e.dateEntretien',
        string $sortDir = 'DESC'
    ): array {
        $allowed = ['e.dateEntretien', 'e.typeEntretien', 'e.statutEntretien', 'e.lieu'];
        if (!in_array($sortBy, $allowed)) $sortBy = 'e.dateEntretien';
        $sortDir = strtoupper($sortDir) === 'ASC' ? 'ASC' : 'DESC';

        $qb = $this->createQueryBuilder('e');

        if ($search) {
            $qb->andWhere('e.lieu LIKE :s OR e.typeTest LIKE :s OR e.typeEntretien LIKE :s OR e.statutEntretien LIKE :s')
               ->setParameter('s', '%' . $search . '%');
        }
        if ($type) {
            $qb->andWhere('e.typeEntretien = :type')->setParameter('type', $type);
        }
        if ($statut) {
            $qb->andWhere('e.statutEntretien = :statut')->setParameter('statut', $statut);
        }

        return $qb->orderBy($sortBy, $sortDir)->getQuery()->getResult();
    }

    public function findForStats(
        ?string $dateDebut = null,
        ?string $dateFin = null,
        ?string $type = null
    ): array {
        $qb = $this->createQueryBuilder('e');

        if ($dateDebut) {
            $qb->andWhere('e.dateEntretien >= :debut')
               ->setParameter('debut', new \DateTime($dateDebut));
        }
        if ($dateFin) {
            $qb->andWhere('e.dateEntretien <= :fin')
               ->setParameter('fin', new \DateTime($dateFin));
        }
        if ($type) {
            $qb->andWhere('e.typeEntretien = :type')
               ->setParameter('type', $type);
        }

        return $qb->orderBy('e.dateEntretien', 'ASC')->getQuery()->getResult();
    }
}
