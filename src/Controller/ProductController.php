<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        //on créé un formulaire avec 2 param: la classe du form et l'objet à ajouter en BDD
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //on veut ajouter l'objet en BDD
            $entityManager= $this->getDoctrine()->getManager();
            // alors on récupere l'entity manage avec Doctrine
            $entityManager->persist($product);
            // on commit l'objet (comme GIt)
            $entityManager->flush();
            //on push l'objet(comme GIt)
            $this->addFlash('success','Le produit a bien été ajouté.');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id){
        dump($id);
        $productRepository= $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'Le produit ' . $id . ' n\'existe pas.'
        );
        }

        dump($product);

        return $this->render('product/show.html.twig', [
            'product'=>$product,
        ]);
    }
}
