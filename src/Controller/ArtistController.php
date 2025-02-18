<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
}
