<?php

namespace App\Repository;

use App\Entity\Mediafile;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mediafile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mediafile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mediafile[]    findAll()
 * @method Mediafile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediafileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mediafile::class);
    }

    public function findExpired()
    {
        $now = new DateTime();
        $qb = $this->createQueryBuilder('m');
        $qb->andWhere($qb->expr()->lt('m.deletedAt', ':now'))->setParameter('now', $now);
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Mediafile[] Returns an array of Mediafile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mediafile
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
