<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Entretien;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEntretien', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Date de l\'entretien',
            ])
            ->add('heureEntretien', TimeType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Heure',
            ])
            ->add('typeEntretien', ChoiceType::class, [
                'choices' => ['RH' => 'RH', 'TECHNIQUE' => 'TECHNIQUE'],
                'required' => true,
                'placeholder' => '-- Choisir --',
                'label' => 'Type d\'entretien',
            ])
            ->add('statutEntretien', ChoiceType::class, [
                'choices' => [
                    'Planifié' => 'Planifié',
                    'Terminé' => 'Terminé',
                    'Annulé' => 'Annulé',
                    'En attente' => 'En attente',
                ],
                'required' => true,
                'placeholder' => '-- Choisir --',
                'label' => 'Statut',
            ])
            ->add('lieu', TextType::class, [
                'required' => true,
                'label' => 'Lieu',
            ])
            ->add('typeTest', TextType::class, [
                'required' => true,
                'label' => 'Type de test',
            ])
            ->add('lienReunion', UrlType::class, [
                'required' => false,
                'label' => 'Lien de réunion',
                'default_protocol' => 'https',
            ])
            ->add('idCandidature', EntityType::class, [
                'class' => Candidature::class,
                'choice_label' => 'idCandidature',
                'choice_value' => 'idCandidature',
                'required' => false,
                'placeholder' => '-- Choisir une candidature --',
                'label' => 'Candidature',
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('c')
                        ->orderBy('c.id_candidature', 'DESC');
                },
            ])
            ->add('idUtilisateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getPrenom() . ' ' . $user->getNom() . ' (' . $user->getEmail() . ')';
                },
                'choice_value' => 'id',
                'required' => false,
                'placeholder' => '-- Choisir un utilisateur --',
                'label' => 'Utilisateur',
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('u')
                        ->orderBy('u.prenom', 'ASC');
                },
            ])
            ->add('questionsEntretien', TextareaType::class, [
                'required' => false,
                'label' => 'Questions',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Entretien::class]);
    }
}
