<?php

namespace App\Repository;

use App\Entity\Single;
use Psr\Log\LoggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Single>
 */
class SingleRepository extends ServiceEntityRepository
{
    private $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Single::class);
        $this->logger = $logger;
    }

    public function findByName($name)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.title LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }

    public function findBySearchQuery(string $query)
    {
        try {
            $qb = $this->createQueryBuilder('s')
                    ->where('s.title LIKE :name')
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
