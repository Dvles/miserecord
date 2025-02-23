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

    public function findByTitle(string $query)
    {
        return $this->createQueryBuilder('s')
            ->where('s.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }
    
    
}
