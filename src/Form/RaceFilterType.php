<?php

namespace App\Form;

use App\Repository\RaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceFilterType extends AbstractType
{
    private RaceRepository $raceRepository;

    public function __construct(RaceRepository $raceRepository)
    {
        $this->raceRepository = $raceRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupération des races depuis la base de données
        $races = $this->raceRepository->findAll();
       
        // Préparation des choix pour le champ select
        $choices = [];
        foreach ($races as $race) {
            $choices[$race->getRaceName()] = $race->getRaceName(); // Nom visible => Valeur soumise
        }

        $builder
            ->add('race', ChoiceType::class, [
                'choices' => $choices, // Utilisation des choix dynamiques
                'placeholder' => 'Choisissez une race',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Le formulaire n'est pas lié à une entité spécifique
        ]);
    }
}
