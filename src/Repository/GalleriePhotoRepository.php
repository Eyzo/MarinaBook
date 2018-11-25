<?php

namespace App\Repository;

use App\Entity\GalleriePhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GalleriePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleriePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleriePhoto[]    findAll()
 * @method GalleriePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleriePhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GalleriePhoto::class);
    }

    // /**
    //  * @return GalleriePhoto[] Returns an array of GalleriePhoto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GalleriePhoto
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
