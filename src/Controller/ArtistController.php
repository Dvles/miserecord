<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Repository\ArtistRepository;
use App\Repository\ArtistPhotoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'artist/index.html.twig',
        ]);
    }


    #[Route('/artist/list', name: 'artist_list')]
    public function artistList(Request $request, ArtistRepository $artistRepository, GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findAll();
        $genreId = $request->query->get('genre', null);
    
        if ($genreId) {
            $genre = $genreRepository->find($genreId);
            if ($genre) {
                $artists = $artistRepository->findByGenre($genre);
            } else {
                $artists = [];
            }
        } else {
            $artists = $artistRepository->findAll();
        }
    
        // Pass the artists and genres to the template
        return $this->render('artist/artist_list.html.twig', [
            'artists' => $artists,
            'genres' => $genres, // Include genres for the filter dropdown
        ]);
    }
    

    #[Route('/artist/profile/{artist_id}', name: 'artist_profile')]
    public function artistSingle(ArtistRepository $artistRepository, ArtistPhotoRepository $artistPhotoRepository, Request $request): Response
    {
        $artist_id = $request->get('artist_id');
        $artistDetails = $artistRepository->find($artist_id);
        
        if (!$artistDetails) {
            throw $this->createNotFoundException('Artist not found');
        }
    
        // Fetch associated photos for this artist
        $artistPhotos = $artistPhotoRepository->findBy(['artist' => $artistDetails]);
    
        $artistData = [
            'id' => $artistDetails->getId(),
            'name' => $artistDetails->getArtistName(),
            'firstName' => $artistDetails->getFirstName(),
            'lastName' => $artistDetails->getLastName(),
            'birthdate' => $artistDetails->getBirthDate(),
            'bio' => $artistDetails->getBio(),
            'album' => $artistDetails->getAlbum(),
            'single' => $artistDetails->getSingles(),
            'isBand' => $artistDetails->getIsBand(),
            'artistPhotos' => $artistPhotos, // Add the photos to the artist data
        ];
        
        $relatedProducts = $artistDetails->getArtistProduct();

        return $this->render('artist/artist_single.html.twig', [
            'artist' => $artistData,
            'relatedProducts' => $relatedProducts, // Pass related products
        ]);
    }
    
    
}
