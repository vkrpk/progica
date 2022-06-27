<?php

namespace App\Repository;

use App\Entity\ViewEquipementGite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ViewEquipementGite>
 *
 * @method ViewEquipementGite|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewEquipementGite|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewEquipementGite[]    findAll()
 * @method ViewEquipementGite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewEquipementGiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewEquipementGite::class);
    }

    public function add(ViewEquipementGite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ViewEquipementGite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ViewEquipementGite[] Returns an array of ViewEquipementGite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ViewEquipementGite
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
