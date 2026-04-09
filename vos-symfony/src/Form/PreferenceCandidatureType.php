<?php

namespace App\Form;

use App\Entity\PreferenceCandidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class PreferenceCandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Type de poste souhaité - Champ texte
            ->add('type_poste_souhaite', TextType::class, [
                'label' => 'Type de poste souhaité',
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le type de poste est obligatoire.']),
                    new Length(['min' => 2, 'max' => 100]),
                ],
                'attr' => [
                    'placeholder' => 'Ex: Développeur, Designer, Manager...',
                    'class' => 'form-control'
                ]
            ])
            
            // Mode de travail - Liste déroulante
            ->add('mode_travail', ChoiceType::class, [
                'label' => 'Mode de travail',
                'required' => false,
                'placeholder' => '-- Sélectionnez un mode de travail --',
                'choices' => [
                    '100% Présentiel' => '100% Présentiel',
                    '100% Télétravail' => '100% Télétravail',
                    'Hybride' => 'Hybride',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le mode de travail est obligatoire.']),
                    new Choice(['choices' => ['100% Présentiel', '100% Télétravail', 'Hybride']]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            
            // Disponibilité - Liste déroulante
            ->add('disponibilite', ChoiceType::class, [
                'label' => 'Disponibilité',
                'required' => false,
                'placeholder' => '-- Sélectionnez votre disponibilité --',
                'choices' => [
                    'Immédiatement' => 'Immédiatement',
                    'Dans 1 mois' => 'Dans 1 mois',
                    'Dans 3 mois' => 'Dans 3 mois',
                    'Dans 6 mois' => 'Dans 6 mois',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La disponibilite est obligatoire.']),
                    new Choice(['choices' => ['Immédiatement', 'Dans 1 mois', 'Dans 3 mois', 'Dans 6 mois']]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            
            // Mobilité géographique - Liste déroulante
            ->add('mobilite_geographique', ChoiceType::class, [
                'label' => 'Mobilité géographique',
                'required' => false,
                'placeholder' => '-- Sélectionnez votre mobilité --',
                'choices' => [
                    'Oui, national' => 'Oui, national',
                    'Oui, région' => 'Oui, région',
                    'Non' => 'Non',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La mobilite geographique est obligatoire.']),
                    new Choice(['choices' => ['Oui, national', 'Oui, région', 'Non']]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            
            // Prêt au déplacement - Liste déroulante
            ->add('pret_deplacement', ChoiceType::class, [
                'label' => 'Prêt au déplacement',
                'required' => false,
                'placeholder' => '-- Sélectionnez votre disponibilité --',
                'choices' => [
                    'Jamais' => 'Jamais',
                    'Occasionnel' => 'Occasionnel',
                    'Fréquent' => 'Fréquent',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le pret au deplacement est obligatoire.']),
                    new Choice(['choices' => ['Jamais', 'Occasionnel', 'Fréquent']]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            
            // Type de contrat souhaité - Liste déroulante
            ->add('type_contrat_souhaite', ChoiceType::class, [
                'label' => 'Type de contrat souhaité',
                'required' => false,
                'placeholder' => '-- Sélectionnez un type de contrat --',
                'choices' => [
                    'CDI' => 'CDI',
                    'CDD' => 'CDD',
                    'Stage' => 'Stage',
                    'Alternance' => 'Alternance',
                    'Freelance' => 'Freelance',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le type de contrat souhaite est obligatoire.']),
                    new Choice(['choices' => ['CDI', 'CDD', 'Stage', 'Alternance', 'Freelance']]),
                ],
                'attr' => ['class' => 'form-control']
            ])
            
            // Prétention salariale - Champ numérique
            ->add('pretention_salariale', MoneyType::class, [
                'label' => 'Prétention salariale (TND)',
                'required' => false,
                'currency' => 'TND',
                'divisor' => 1,
                'constraints' => [
                    new PositiveOrZero(['message' => 'La pretention salariale doit etre positive.']),
                ],
                'attr' => [
                    'placeholder' => '0',
                    'class' => 'form-control'
                ],
                'help' => 'Entrez le salaire annuel souhaité'
            ])
            
            // Date de disponibilité - Calendrier
            ->add('date_disponibilite', DateType::class, [
                'label' => 'Date de disponibilité',
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'input' => 'datetime',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'type' => 'date',
                    'class' => 'form-control'
                ],
                'help' => 'La date doit être dans le futur'
            ])
        ;
        // Remarque: id_utilisateur n'est pas inclus car il est défini automatiquement par le controller
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PreferenceCandidature::class,
        ]);
    }
}
