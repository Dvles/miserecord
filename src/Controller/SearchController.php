<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArtistRepository;
use App\Repository\AlbumRepository;
use App\Repository\SingleRepository;

class SearchController extends AbstractController
{
    #[Route('/search/results', name: 'ajax_search')]
    public function ajaxSearch(Request $request, ArtistRepository $artistRepo, AlbumRepository $albumRepo, SingleRepository $singleRepo)
    {
        // Get search query from the request
        $query = $request->query->get('query');

        // Search for artists, albums, and singles that match the query
        $artists = $artistRepo->findByName($query);
        $albums = $albumRepo->findByTitle($query);
        $singles = $singleRepo->findByTitle($query);

        // Return results as a rendered HTML fragment (partial view)
        return $this->render('search/results.html.twig', [
            'artists' => $artists,
            'albums' => $albums,
            'singles' => $singles,
        ]);
    }
}
