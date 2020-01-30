<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $product = new Product();
        $product->setName('Iphone')
                ->setDescription('Mon produit')
                ->setPrice(999);

        $entityManager = $this->getDoctrine()->getManager();
        //persist est l'INSERT/UPDATE
        $entityManager->persist($product);
        //flush execute la requête
        $entityManager->flush();

        return $this->render('index/index.html.twig', [

        ]);
    }
}
