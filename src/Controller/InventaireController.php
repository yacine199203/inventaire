<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Inventaire;
use App\Repository\ProductRepository;
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
    public function add($slug,$id,$ref,$product,$color,$qte,ProductRepository $productRepo,InventaireRepository $inventaireRepo): Response
    {
        $addProduct= $productRepo->findByRef($ref);
        $inv= $inventaireRepo->findOneBySlug($slug);
        $addProductId= $productRepo->findOneByInventaire($inv->getId());
        $test=false;
        foreach ($addProduct as $value){
            if($value->getInventaire()->getId() == $inv->getId()){
                $test=true;
                $addProduct= $productRepo->findOneById($value->getId());
            }
        }
     
        if(($addProduct != null)&&($test)){
            $quantité=$addProduct->getQte();
            $quantité += $qte;
            $addProduct->setQte($quantité);
            
        }else
        {
            $addProduct = new Product();
            $post = $this->getDoctrine()->getRepository(Inventaire::class)->find($id);
            $addProduct->setInventaire($post);
            $addProduct->setRef($ref);
            $addProduct->setProductName($product);
            $addProduct->setColor($color);
            $addProduct->setQte($qte); 
        }
        

        $manager=$this->getDoctrine()->getManager();
        $manager->persist($addProduct); 
        $manager->flush();
        
        return $this->redirectToRoute('inventaire', [
            'slug' => $slug
        ]);
    }
    /**
     * @Route("/inventaire/{slug}/supprimer-produit/{id} ", name="removeProduct")
     * @return Response
     */
    public function removeCategory($slug,$id,ProductRepository $productRepo)
    {   
        $removeProduct = $productRepo->findOneById($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($removeProduct); 
        $manager->flush();
        return $this->redirectToRoute('inventaire', [
            'slug' => $slug
        ]);
    }
}