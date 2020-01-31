<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAllGreaterThanPrice(1);
        $favoriteProduct = $productRepository->findOneGreaterThanPrice(2);

        dump($products);
        dump($favoriteProduct);


        return $this->render('index/index.html.twig', [
            'products' => $products,
            'favorite_product' => $favoriteProduct,
        ]);
    }

}