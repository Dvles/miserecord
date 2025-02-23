<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Single;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\SingleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

class SearchController extends AbstractController
{
    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    #[Route('/search/results', name: 'ajax_search')]
    public function ajaxSearch(Request $request): JsonResponse
    {
        $query = $request->query->get('query');
        
        if (!$query) {
            return new JsonResponse([]);
        }

        try {
            // Log the incoming query to check if the request is received correctly
            $this->logger->info('Search query received: ' . $query);

            // Get the repository for each entity
            $artistRepo = $this->entityManager->getRepository(Artist::class);
            $albumRepo = $this->entityManager->getRepository(Album::class);
            $singleRepo = $this->entityManager->getRepository(Single::class);

            // Log the repositories to ensure they are properly loaded
            $this->logger->info('Repositories loaded: Artist, Album, Single');

            // Call the custom methods on the repositories
            $artists = $artistRepo->findBySearchQuery($query);
            $albums = $albumRepo->findBySearchQuery($query);
            $singles = $singleRepo->findBySearchQuery($query);

            // Log the results to ensure we're getting some data
            $this->logger->info('Results found: Artists - ' . count($artists) . ', Albums - ' . count($albums) . ', Singles - ' . count($singles));

            // Combine all results into one array
            $results = array_merge($artists, $albums, $singles);

            return new JsonResponse($results);
        } catch (\Exception $e) {
            // Log the full exception trace for detailed debugging
            $this->logger->error('Error in search results: ' . $e->getMessage());
            $this->logger->error('Stack trace: ' . $e->getTraceAsString());
            $this->logger->info('Search query received: ' . $query);



            return new JsonResponse(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
}
