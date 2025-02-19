<?php

namespace App\Controller;

use App\Repository\SingleRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


final class SingleController extends AbstractController
{



    #[Route('/single/{artist_id}', name: 'single_list')]
    public function artistList(SingleRepository $singleRepository, Request $request): Response
    {
        $artist_id = $request->get('artist_id');
        $singles = $singleRepository->findAll();
        $vars = [
            'singles' => $singles,
        ];
        
        return $this->render('single/single_list.html.twig', $vars);
    }

    
}
