<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\SingleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class SearchController extends AbstractController
{
    private $artistRepository;
    private $albumRepository;
    private $singleRepository;
    private $logger;

    public function __construct(ArtistRepository $artistRepository, AlbumRepository $albumRepository, SingleRepository $singleRepository, LoggerInterface $logger)
    {
        $this->artistRepository = $artistRepository;
        $this->albumRepository = $albumRepository;
        $this->singleRepository = $singleRepository;
        $this->logger = $logger;
    }

    #[Route('/search/results', name: 'ajax_search', methods: ['GET'])]
    public function searchAction(Request $request): JsonResponse
    {
        $query = $request->query->get('query', '');

        if (empty($query)) {
            return new JsonResponse(['error' => 'No search term provided'], 400);
        }

        // Search in different repositories
        $artists = $this->artistRepository->findByName($query);
        $albums = $this->albumRepository->findByTitle($query);
        $singles = $this->singleRepository->findByTitle($query);

        $results = [];

        foreach ($artists as $artist) {
            $results[] = [
                'name' => $artist->getArtistName(),
                'url' => $this->generateUrl('artist_profile', ['artist_id' => $artist->getId()])
            ];
        }

        foreach ($albums as $album) {
            $results[] = [
                'name' => 'Album: ' . $album->getTitle(),
                'url' => $this->generateUrl('album_detail', ['id' => $album->getId()])
            ];
        }

        foreach ($singles as $single) {
            $results[] = [
                'name' => 'Single: ' . $single->getTitle(),
                'url' => $this->generateUrl('single_detail', ['id' => $single->getId()])
            ];
        }

        if (empty($results)) {
            return new JsonResponse(['error' => 'No results found'], 404);
        }

        return new JsonResponse($results);
    }
}
