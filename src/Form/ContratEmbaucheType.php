<?php

namespace App\Form;

use App\Entity\ContratEmbauche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratEmbaucheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeContrat', TextType::class, ['label' => 'Type de contrat'])
            ->add('dateDebut', DateType::class, ['widget' => 'single_text', 'label' => 'Date de début'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text', 'label' => 'Date de fin'])
            ->add('salaire', MoneyType::class, ['currency' => 'EUR', 'label' => 'Salaire'])
            ->add('status', TextType::class, ['label' => 'Statut'])
            ->add('volumeHoraire', TextType::class, ['label' => 'Volume horaire'])
            ->add('avantages', TextareaType::class, ['label' => 'Avantages', 'required' => false])
            ->add('idRecrutement', IntegerType::class, ['label' => 'ID Recrutement'])
            ->add('periode', TextType::class, ['label' => 'Période'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer', 'attr' => ['class' => 'btn-save']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => ContratEmbauche::class]);
    }
}
