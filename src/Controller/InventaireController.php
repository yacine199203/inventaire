<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Inventaire;
use App\Repository\InventaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InventaireController extends AbstractController
{
    /**
     * @Route("/inventaire/{slug}", name="inventaire")
     */
    public function index($slug,InventaireRepository $inventaireRepo): Response
    {
        $inventaire= $inventaireRepo->findOneBySlug($slug);
        return $this->render('inventaire/index.html.twig', [
            'inventaire' => $inventaire,
        ]);
    }

    /**
     * @Route("/inventaire/{slug}/{id}", name="product")
     */
    public function ajout($slug,$id): Response
    {
        
        return $this->render('scanner/scanner.html.twig', [
            
        ]);
    }


    /**
     * @Route("/inventaire/{slug}/{id}/{ref}/{product}/{color}/{qte}", name="addProduct")
     */
    public function add($slug,$id,$ref,$product,$color,$qte): Response
    {
        $addProduct = new Product();
        $post = $this->getDoctrine()->getRepository(Inventaire::class)->find($id);
        $addProduct->setInventaire($post);
        $addProduct->setRef($ref);
        $addProduct->setProductName($product);
        $addProduct->setColor($color);
        $addProduct->setQte($qte);

        $manager=$this->getDoctrine()->getManager();
        $manager->persist($addProduct); 
        $manager->flush();
        
        return $this->redirectToRoute('inventaire', [
            'slug' => $slug
        ]);
    }
}
