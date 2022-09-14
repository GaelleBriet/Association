<?php

namespace App\Repository;

use App\Entity\Adhesions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adhesions>
 *
 * @method Adhesions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adhesions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adhesions[]    findAll()
 * @method Adhesions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdhesionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adhesions::class);
    }

    public function add(Adhesions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adhesions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // /**
    //  * @return Adhesions[] Returns an array of Adhesions objects
    //  */
    // public function findByDateOrderedByNewest(): array
    // {
    //     return $this->createQueryBuilder('a')
    //         ->andWhere('a.ending_date IS NOT NULL')
    //         // ->setParameter('val', $value)
    //         ->orderBy('a.ending_date', 'DESC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findOneByDate(): ?Adhesions
    {
        return $this->createQueryBuilder('adhesions')
            ->andWhere('adhesions.ending_date > :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
