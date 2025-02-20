<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class AlbumController extends AbstractController
{




    #[Route('/album/detail/{id}', name: 'album_detail')]
    public function albumDetail(AlbumRepository $albumRepository, Request $request, $id): Response
    {
        // Fetch the album by its ID
        $album = $albumRepository->find($id);
    
        if (!$album) {
            throw $this->createNotFoundException('Album not found'); // CREATE COOL ERROR PAGE
        }
    
        $artist = $album->getArtist();
        $producers = $album->getProducers();
        $genres = $album->getGenres();
        $singles = $album->getSingle();
    
        // Additional album details
        $releaseDate = $album->getReleaseDate();
        $artwork = $album->getArtwork();
        $spotifyLink = $album->getSpotifyLink();
        $youtubeLink = $album->getYoutubeLink();
        $soundcloudLink = $album->getSoundcloudLink();
        $numTracks = $album->getNumTracks();
    
        $vars = [
            'album' => $album,
            'artist' => $artist,
            'producers' => $producers,
            'genres' => $genres,
            'singles' => $singles,
            'releaseDate' => $releaseDate,
            'artwork' => $artwork,
            'spotifyLink' => $spotifyLink,
            'youtubeLink' => $youtubeLink,
            'soundcloudLink' => $soundcloudLink,
            'numTracks' => $numTracks,
        ];
    
        return $this->render('album/album_detail.html.twig', $vars);
    }
    
    
}
