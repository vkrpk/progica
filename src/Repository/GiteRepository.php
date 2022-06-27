<?php

namespace App\Repository;

use App\Entity\Gite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gite>
 *
 * @method Gite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gite[]    findAll()
 * @method Gite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gite::class);
    }

    public function add(Gite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCriteres(array $equipement, ?array $service = [])
    {
        // dd($equipement);
        $conn = $this->getEntityManager()->getConnection();
        $where = (!empty($equipement) OR !empty($service)) ? 'WHERE' : '';
        $and = (!empty($equipement) && !empty($service)) ? 'AND' : '';

        $equipements = empty($equipement) ? [] : implode(',', $equipement );
        $services = empty($service) ? [] : implode(',', $service );

        $sqlEquipementEmpty = empty($equipement) ? '' : 'eg.equipement_id in (:equipements)';
        $sqlServiceEmpty = empty($service) ? '' : 'gs.service_id in (:services)';

        $sql = "
            SELECT g.* FROM gite g
		    INNER JOIN equipement_gite eg ON g.id = eg.gite_id
            INNER JOIN gite_service gs ON g.id = gs.gite_id
		    {$where} {$sqlEquipementEmpty}
		    {$and} {$sqlServiceEmpty}
            GROUP BY g.id;
            ";
            // dd($sql);
            $stmt = $conn->prepare($sql);
            $test = array_merge($equipements !==  [] ?  ['equipements' => $equipements] : [], $services !== [] ? ['services' => $services] : []);
            // $resultSet = $stmt->executeQuery(['equipements' => $equipements, 'services' => $services]);
            $resultSet = $stmt->executeQuery($test);
            // $resultSet->fetchAllAssociativeIndexed();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Gite[] Returns an array of Gite objects
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

//    public function findOneBySomeField($value): ?Gite
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
