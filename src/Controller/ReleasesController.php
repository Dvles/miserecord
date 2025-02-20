<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\SingleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReleasesController extends AbstractController
{
    private $albumRepository;
    private $singleRepository;

    public function __construct(AlbumRepository $albumRepository, SingleRepository $singleRepository)
    {
        $this->albumRepository = $albumRepository;
        $this->singleRepository = $singleRepository;
    }

    #[Route('/releases', name: 'releases_list')]
    public function index(): Response
    {
        $albums = $this->albumRepository->findAll();
        $singles = $this->singleRepository->findAll();

        return $this->render('releases/index.html.twig', [
            'albums' => $albums,
            'singles' => $singles,
        ]);
    }
}
