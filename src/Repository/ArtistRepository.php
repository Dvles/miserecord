<?php

namespace App\Repository;

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

    public function findByArtist($artist)
    {
        return $this->createQueryBuilder('a')
                    ->where('a.artistName = :artist')
                    ->setParameter('artist', $artist)
                    ->getQuery()
                    ->getResult();
    }

    public function findBySearchQuery(string $query)
    {
        try {
            $qb = $this->createQueryBuilder('a')
                       ->where('a.artistName LIKE :query')
                       ->setParameter('query', '%'.$query.'%');
            
            $query = $qb->getQuery();
            $results = $query->getResult();
    
            return $results;
        } catch (\Exception $e) {
            // Log the exception or return an empty array to prevent 500 error
            // Log the error message to Symfony log
            $this->get('logger')->error('Error in findBySearchQuery: '.$e->getMessage());
            
            return [];
        }
    }
}
