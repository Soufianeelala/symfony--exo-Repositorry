<?php

namespace App\Controller;

use App\Form\RaceFilterType;
use App\Repository\SurvivantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {    

        // // Créer le formulaire
        // $form = $this->createForm(RaceFilterType::class);
        // $form->handleRequest($request);
        
                // Filtrer les survivants

        //recuperation de la requête GET qu'on stocke dans $filter
        $filter = $request->get('filter','all');
       if($filter=="asc"){ 
        $survivants = $repository->findByExampleField(); // Trier par "nom" dans l'ordre décroissant          
            ;}
           
        if($filter == "all"){        
            $survivants = $repository->findAll();
        }
        else if($filter=="Nain"){
            $survivants = $repository->Nain("Nain");
        }
        else if($filter=="ELF>=25"){
            $survivants = $repository->puissance(25, 'Elfe');
        }
        else if($filter=="NON-HUMAIN"){
            $survivants = $repository->NonHumain("Humain");
        }
        return $this->render('home/index.html.twig', [
            'survivants' => $survivants,
            //'form' => $form,

        ]);
        
    }
}
