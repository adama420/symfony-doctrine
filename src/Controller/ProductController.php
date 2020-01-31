<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/products", name="product_list")
     */
    public function showList(){
        $productRepository= $this->getDoctrine()->getRepository(Product::class);
        $products = $productRepository->findAll();
        if(!$products){
            throw $this->createNotFoundException(
                'Il n\'y a aucun produit disponnible'
            );
        }
        return $this->render('product/showList.html.twig', [
            'products'=>$products,
        ]);
    }



    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        // On récupère le dépôt qui contient nos produits
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        // SELECT * FROM product WHERE id = $slug
        $product = $productRepository->findOneBy(array('slug' => $slug));
            dump($product);
            dump($slug);
        // Si le produit n'existe pas en BDD
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function editProduct(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);



    }


    /**
     * @Route("/product/del/{id}", name="product_del", methods={"POST"})
     */
    public function deleteProduct(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        // On vérifie la validité du token CSRF
        // On se protège d'une faille CSRF
        if ($this->isCsrfTokenValid('delete', $request->get('token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_list');
}



}
