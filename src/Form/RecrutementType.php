<?php

namespace App\Form;

use App\Entity\Recrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecrutementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDecision', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de décision',
                'attr' => ['placeholder' => 'YYYY-MM-DD'],
            ])
            ->add('decisionFinale', TextType::class, [
                'label' => 'Décision finale',
                'attr' => ['placeholder' => 'Accepté, Refusé, En attente...'],
            ])
            ->add('idEntretien', IntegerType::class, [
                'label' => 'ID Entretien',
                'attr' => ['placeholder' => 'Identifiant de l’entretien'],
            ])
            ->add('idUtilisateur', IntegerType::class, [
                'label' => 'ID Utilisateur',
                'attr' => ['placeholder' => 'Identifiant de l’utilisateur'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn-save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recrutement::class,
        ]);
    }
}
