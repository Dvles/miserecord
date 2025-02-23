<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Artist;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Artist>
 */
class ArtistRepository extends ServiceEntityRepository
{
    private $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Artist::class);
        $this->logger = $logger;
    }
    public function findByName(string $query)
    {
        return $this->createQueryBuilder('a')
            ->where('a.artistName LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    public function findByGenre(Genre $genre)
    {
        return $this->createQueryBuilder('a')
        ->innerJoin('a.album', 'al')  
        ->innerJoin('al.genres', 'g')
        ->andWhere('g.id = :genreId')
        ->setParameter('genreId', $genre->getId())
        ->getQuery()
        ->getResult();
    }


}
