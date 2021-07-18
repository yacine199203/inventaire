<?php

namespace App\Controller;

use App\Entity\Inventaire;
use App\Form\InventaireType;
use App\Repository\InventaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(InventaireRepository $inventaireRepo): Response
    {
        $inventaires = $inventaireRepo->findAll();
        return $this->render('home/index.html.twig', [
            'inventaires' => $inventaires,
        ]);
    }

    /**
     *  
     * @Route("/ajouter-inventaire", name="addInventaire")
     * 
     * @return Response
     */
    public function addCategory(InventaireRepository $inventaireRepo,Request $request)
    {
        $addInventaire = new Inventaire();
        $addInvForm = $this->createForm(InventaireType::class,$addInventaire);
        $addInvForm-> handleRequest($request);
        if($addInvForm->isSubmitted() && $addInvForm->isValid())
        {
                $manager=$this->getDoctrine()->getManager();
                $manager->persist($addInventaire); 
                $manager->flush();
                $this->addFlash(
                    'success',
                    "L'inventaire <strong>".$addInventaire->getLibelle()."</strong> a bien été ajouté"
                );
                return $this-> redirectToRoute('home');
        }
        
        return $this->render('home/addInventaire.html.twig', [
            'addInvForm'=> $addInvForm->createView(),
        ]);
    }

    /**
     * @Route("/dashbord/supprimer-inventaire/{id} ", name="removeInventaire")
     * @return Response
     */
    public function removeCategory($id,InventaireRepository $inventaireRepo)
    {   
        $removeInventaire = $inventaireRepo->findOneById($id);
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($removeInventaire); 
        $manager->flush();
            return $this-> redirectToRoute('home');
    }
}
