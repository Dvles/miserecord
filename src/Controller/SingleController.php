<?php

namespace App\Controller;

use App\Repository\SingleRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


final class SingleController extends AbstractController
{



    #[Route('/single/{artist_id}', name: 'single_list')]
    public function artistList(SingleRepository $singleRepository, ArtistRepository $artistRepository, Request $request): Response
    {
        $artist_id = $request->get('artist_id');
        
        $artist = $artistRepository->find($artist_id);
        
        if (!$artist) {
            throw $this->createNotFoundException('Artist not found');
        }
    
        $singles = $singleRepository->findBy(['artist' => $artist], ['releaseDate' => 'DESC']);
    
        $vars = [
            'singles' => $singles,
            'artist' => $artist
        ];
        
        return $this->render('single/single_list.html.twig', $vars);
    }

    #[Route('/single/detail/{id}', name: 'single_detail')]
    public function singleDetail(SingleRepository $singleRepository, Request $request, $id): Response
    {
        // Fetch the single by its ID
        $single = $singleRepository->find($id);

        if (!$single) {
            throw $this->createNotFoundException('Single not found'); // CREATE COOL ERROR PAGE
        }

        $artist = $single->getArtist();
        $album = $single->getAlbum();
        $producers = $single->getProducers();
        $genres = $single->getGenres();

        return $this->render('single/single_detail.html.twig', [
            'single' => $single,
            'artist' => $artist,
            'album' => $album,
            'producers' => $producers,
            'genres' => $genres
        ]);
    }
    

    
}
