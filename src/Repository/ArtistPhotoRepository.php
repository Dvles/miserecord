<?php

namespace App\Repository;

use App\Entity\ArtistPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtistPhoto>
 */
class ArtistPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistPhoto::class);
    }

    public function findByName($name)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.artistName LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }
}
