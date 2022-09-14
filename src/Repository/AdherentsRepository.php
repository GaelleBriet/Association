<?php

namespace App\Repository;

use App\Entity\Adherents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adherents>
 *
 * @method Adherents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adherents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adherents[]    findAll()
 * @method Adherents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdherentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherents::class);
    }

    public function findAllWithLastAdhesion(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT adherents.id, adherents.first_name, adherents.last_name, adherents.tel, adherents.email, CAST(MAX(adhesions.ending_date) AS CHAR),
        CASE 
        WHEN MAX(adhesions.ending_date)>now() THEN CAST(MAX(adhesions.ending_date) AS CHAR)
        ELSE ""
        end derniere_adhesion
        from adherents left join adhesions 
        on adherents.id = adhesions.adherent_id 
        group by adherents.id
        ORDER BY derniere_adhesion ASC
        ;
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        //dump($resultSet);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function add(Adherents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adherents $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // /**
    //  * @return Adherents[] Returns an array of Adherents objects
    //  */
    // public function findByDate($value): array
    // {
    //     return $this->createQueryBuilder('a')
    //         ->andWhere('a.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('a.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    //    public function findOneBySomeField($value): ?Adherents
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
