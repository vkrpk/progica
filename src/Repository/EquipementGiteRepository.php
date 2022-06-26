<?php

namespace App\Repository;

use App\Entity\EquipementGite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipementGite>
 *
 * @method EquipementGite|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipementGite|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipementGite[]    findAll()
 * @method EquipementGite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipementGiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipementGite::class);
    }

    public function add(EquipementGite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EquipementGite $entity, bool $flush = false): void
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
            SELECT e.nom FROM equipement e
            INNER JOIN equipement_gite eg
            ON e.id = eg.equipement_id
            WHERE eg.gite_id = :id;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return EquipementGite[] Returns an array of EquipementGite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EquipementGite
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
