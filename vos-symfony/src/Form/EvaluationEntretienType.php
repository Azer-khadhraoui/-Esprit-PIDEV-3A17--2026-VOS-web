<?php

namespace App\Form;

use App\Entity\Entretien;
use App\Entity\EvaluationEntretien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class EvaluationEntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $noteChoices = array_combine(range(0, 5), range(0, 5));

        $builder
            ->add('entretien', EntityType::class, [
                'class' => Entretien::class,
                'choice_label' => static function (Entretien $entretien): string {
                    return sprintf('#%d - %s %s', $entretien->getId(), $entretien->getDateEntretien()?->format('d/m/Y') ?? '', $entretien->getTypeEntretien() ?? '');
                },
                'placeholder' => '-- Choisir un entretien --',
                'required' => false,
                'label' => 'Entretien',
                'constraints' => [new NotBlank(['message' => 'Veuillez choisir un entretien.'])],
            ])
            ->add('scoreTest', NumberType::class, [
                'required' => false,
                'label' => 'Score (/100)',
                'scale' => 1,
                'constraints' => [
                    new NotBlank(['message' => 'Le score est obligatoire.']),
                    new Range(['min' => 0, 'max' => 100]),
                ],
            ])
            ->add('noteEntretien', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '-- Note --',
                'label' => 'Note (/5)',
                'constraints' => [
                    new NotBlank(['message' => 'La note est obligatoire.']),
                    new Choice(['choices' => range(0, 5)]),
                ],
            ])
            ->add('decision', ChoiceType::class, [
                'choices' => ['Accepté' => 'Accepté', 'Refusé' => 'Refusé', 'En attente' => 'En attente'],
                'required' => false,
                'placeholder' => '-- Décision --',
                'label' => 'Décision',
                'constraints' => [
                    new NotBlank(['message' => 'La decision est obligatoire.']),
                    new Choice(['choices' => ['Accepté', 'Refusé', 'En attente']]),
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire',
                'constraints' => [
                    new NotBlank(['message' => 'Le commentaire est obligatoire.']),
                    new Length(['min' => 3, 'max' => 2000]),
                ],
            ])
            ->add('competencesTechniques', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '--',
                'label' => 'Compétences techniques',
                'constraints' => [new NotBlank(['message' => 'Ce champ est obligatoire.'])],
            ])
            ->add('competencesComportementales', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '--',
                'label' => 'Comportementales',
                'constraints' => [new NotBlank(['message' => 'Ce champ est obligatoire.'])],
            ])
            ->add('communication', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '--',
                'label' => 'Communication',
                'constraints' => [new NotBlank(['message' => 'Ce champ est obligatoire.'])],
            ])
            ->add('motivation', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '--',
                'label' => 'Motivation',
                'constraints' => [new NotBlank(['message' => 'Ce champ est obligatoire.'])],
            ])
            ->add('experience', ChoiceType::class, [
                'choices' => $noteChoices,
                'required' => false,
                'placeholder' => '--',
                'label' => 'Expérience',
                'constraints' => [new NotBlank(['message' => 'Ce champ est obligatoire.'])],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => EvaluationEntretien::class]);
    }
}
