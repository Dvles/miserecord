<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


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
    public function artistList(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();
        $vars = [
            'artists' => $artists,
        ];
        
        return $this->render('artist/artist_list.html.twig', $vars);
    }

    #[Route('/artist/{artist_id}', name: 'artist_single')]
    public function artistSingle(ArtistRepository $artistRepository, Request $request): Response
    {
        $artist_id = $request->get('artist_id');
        $artistDetails = $artistRepository->find($artist_id);
        if (!$artistDetails) {
            throw $this->createNotFoundException('Artist not found');
        }

        $artistData = [];
        foreach ($artistDetails as $artistData) {
            $toolReviewData[] = [
                'id' => $artistData->getId(),
                'name' => $artistData->getArtistName(),
                'firstName' => $artistData->getFirsttName(),
                'lastName' => $artistData->getLastName(),
                'birthdate' => $artistData->getBirthDate(),
                'bio' => $artistData->getBio(),
                'album' => $artistData->getAlbums(),
                'single' => $artistData->getSingle(),
                'isBand'=>$artistData->getIsBand()
            ];
        }
        
        $vars = [
            'artist' => $artistData,
        ];
        
        return $this->render('artist/artist_list.html.twig', $vars);
    }
}
