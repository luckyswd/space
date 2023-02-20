<?php

namespace App\Repository;

use App\Entity\Record;
use App\Entity\Space;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

class RecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    public function getRecordsBySpace(
        Space $space,
    )
    {
        return $this->createQueryBuilder('r')
            ->join('r.client', 'c')
            ->andWhere('c.space = :space')
            ->setParameter('space', $space)
            ->getQuery()
            ->getResult();
    }
}
