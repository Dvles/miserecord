<?php

// src/Controller/ProducerController.php
namespace App\Controller;

use App\Repository\ProducerRepository;
use App\Repository\SingleRepository;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducerController extends AbstractController
{
    private $producerRepository;
    private $singleRepository;
    private $albumRepository;

    public function __construct(
        ProducerRepository $producerRepository,
        SingleRepository $singleRepository,
        AlbumRepository $albumRepository
    ) {
        $this->producerRepository = $producerRepository;
        $this->singleRepository = $singleRepository;
        $this->albumRepository = $albumRepository;
    }

    #[Route('/producer/detail/{id}', name: 'producer_detail')]
    public function producerDetail($id): Response
    {
        // Fetch the producer by its ID
        $producer = $this->producerRepository->find($id);

        if (!$producer) {
            throw $this->createNotFoundException('Producer not found');
        }

        // Get all singles and albums that the producer collaborated on
        $singles = $producer->getSingles();
        $albums = $producer->getAlbums();

        return $this->render('producer/producer_detail.html.twig', [
            'producer' => $producer,
            'singles' => $singles,
            'albums' => $albums,
        ]);
    }
}
