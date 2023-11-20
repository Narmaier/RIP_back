<?php

namespace App\Repository;

use App\Entity\StaffMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StaffMember>
 *
 * @method StaffMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffMember[]    findAll()
 * @method StaffMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaffMember::class);
    }
    public function addToRep(StaffMember $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }

    public function deleteFromRep(StaffMember $object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();
    }
//    /**
//     * @return StaffMember[] Returns an array of StaffMember objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StaffMember
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
