<?php

namespace App\Repository;

use App\Entity\GiteService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GiteService>
 *
 * @method GiteService|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiteService|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiteService[]    findAll()
 * @method GiteService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiteServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GiteService::class);
    }

    public function add(GiteService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GiteService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByGite(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT s.nom FROM service s
            INNER JOIN gite_service gs
            ON s.id = gs.service_id
            WHERE gs.gite_id = :id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return GiteService[] Returns an array of GiteService objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GiteService
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
