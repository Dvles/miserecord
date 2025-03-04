<?php

namespace App\Controller;

use App\Enum\ProductTypesEnum;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function productList(ProductRepository $productRepository, Request $request): Response
    {
        $type = $request->query->get('type'); 
    
        if ($type && ProductTypesEnum::tryFrom($type)) {
            // Ensure the passed type is valid
            $products = $productRepository->findBy(['type' => ProductTypesEnum::from($type)]);
        } else {
            $products = $productRepository->findAll();
        }
    
        return $this->render('product/product_list.html.twig', [
            'products' => $products,
            'selectedType' => $type, 
        ]);
    }
    

    #[Route('/product/{id}', name: 'product_detail')]
    public function productDetail(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/product_detail.html.twig', [
            'product' => $product,
        ]);
    }
}
