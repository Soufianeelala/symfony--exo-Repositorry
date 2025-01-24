<?php
namespace App\Controller;

// Importation des classes nécessaires
use App\Form\RaceFilterType; // Formulaire pour le filtrage des survivants
use App\Repository\SurvivantRepository; // Repository pour interagir avec la base de données
use Symfony\Component\HttpFoundation\Request; // Pour gérer les requêtes HTTP
use Symfony\Component\HttpFoundation\Response; // Pour construire la réponse HTTP
use Symfony\Component\Routing\Attribute\Route; // Annotation pour définir les routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Contrôleur Symfony de base

final class FiltreSurvivantController extends AbstractController
{
    #[Route('/filtre/survivant', name: 'app_filtre_survivant')] // Route pour accéder à cette page
    public function index(SurvivantRepository $repository, Request $request): Response
    {
        // Créer un formulaire basé sur RaceFilterType
        $form = $this->createForm(RaceFilterType::class);
        $form->handleRequest($request); // Gère la requête (lecture des données soumises, validation, etc.)

        // Initialisation d'une variable pour stocker les survivants à afficher
        $survivants = [];

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données envoyées via le formulaire
            $data = $form->getData();
            // Exemple : dd($data) permettrait de voir ce qui a été soumis par le formulaire
            // $data contient un tableau avec les clés : 'race', 'puissance_min', et potentiellement d'autres.
           
            // Préparer un tableau de critères pour le filtrage
            $criteria = [];

            // Si une race a été sélectionnée dans le formulaire, on l'ajoute aux critères
            if ($data['race']) {
                $criteria['race'] = $data['race']; // Filtrage par race
            }

            // Si une puissance minimale est définie, on l'ajoute aussi aux critères
            if (isset($data['puissance_min']) && $data['puissance_min'] !== null) {
                $criteria['puissance'] = $data['puissance_min']; // Filtrage par puissance minimale
            }

            // Vérifie si des classes sont sélectionnées
            $classes = $data['classe'] ?? []; // Les classes sélectionnées (liste d'IDs)
            if (!empty($classes)) {
                $criteria['classe'] = $classes;
            }

            // Si au moins un critère est défini, on effectue une recherche filtrée
            if (!empty($criteria)) {
                // Appel du repository pour chercher les survivants correspondant aux critères
                $survivants = $repository->findByCriteria($criteria);
            }
        } else {
            // Si le formulaire n'a pas été soumis, on récupère tous les survivants
            $survivants = $repository->findAll(); // Recherche sans filtre
        }
       //dd($classes);// Affiche toutes les instances retournées par le repository
        // Rendu de la vue avec les survivants et le formulaire
        return $this->render('filtre_survivant/filtreSurvivant.html.twig', [
            'survivants' => $survivants, // Liste des survivants à afficher
            'form' => $form->createView(), // Vue du formulaire
        ]);
    }
}
