<?php

namespace App\Form;

use App\Repository\ClasseRepository;
use App\Repository\RaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RaceFilterType extends AbstractType
{
    private RaceRepository $raceRepository;
    private ClasseRepository $classeRepository;

    public function __construct(RaceRepository $raceRepository, ClasseRepository $classeRepository)
    {
        $this->raceRepository = $raceRepository;
        $this->classeRepository = $classeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupération des races depuis la base de données
        $races = $this->raceRepository->findAll();
       
        // Préparation des choix pour le champ select
        $raceChoices = [];
        foreach ($races as $race) {
            $raceChoices[$race->getRaceName()] = $race->getRaceName(); // Nom visible => Valeur soumise
        }

        // Récupération des classes depuis la base de données
        $classes = $this->classeRepository->findAll();
        $classChoices = [];
        foreach ($classes as $class) {
            $classChoices[$class->getClassName()] = $class->getId(); // Nom visible => ID soumis
        }

        $builder
            ->add('race', ChoiceType::class, [
                'choices' => $raceChoices,
                'placeholder' => 'Choisissez une race',
                'required' => false,
            ])
            ->add('puissance_min', NumberType::class, [
                'label' => 'Puissance minimum',
                'required' => false,
                'attr' => ['placeholder' => 'Puissance minimale']
            ])
            ->add('classes', ChoiceType::class, [
                'choices' => $classChoices,
                'expanded' => true, // Case à cocher
                'multiple' => true, // Permet de sélectionner plusieurs classes
                'label' => 'Classes',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
