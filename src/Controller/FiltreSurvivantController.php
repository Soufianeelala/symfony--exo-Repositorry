<?php

namespace App\Controller;


use App\Form\RaceFilterType;
use App\Repository\SurvivantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FiltreSurvivantController extends AbstractController
{
    #[Route('/filtre/survivant', name: 'app_filtre_survivant')]
    public function index(SurvivantRepository $repository, Request $request): Response
    {
        // Créer le formulaire
        $form = $this->createForm(RaceFilterType::class);
        $form->handleRequest($request);
    
       
        // Filtrer les survivants
        $survivants = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('race')->getData();
            $race = $data['race'] ?? 'all';

            if ($race === 'all') {
                $survivants = $repository->findAll();
            } elseif ($race === 'Humain') {
                $survivants = $repository->Humain('Humain');
            } else {
                $survivants = $repository->findBy(['race.nom' => $race]);
            }
        } else {
            // Par défaut, on affiche tous les survivants
            $survivants = $repository->findAll();
        }
       
        return $this->render('filtre_survivant/filtreSurvivant.html.twig', [
            'survivants' => $survivants,
            'form' => $form,
            
        ]);
    }
}
