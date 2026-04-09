<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Entretien;
use App\Entity\User;
use App\Repository\CandidatureRepository;
use App\Repository\UserRepository;
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
    public function __construct(
        private CandidatureRepository $candidatureRepository,
        private UserRepository $userRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $candidatureChoices = [];
        foreach ($this->candidatureRepository->createQueryBuilder('c')->orderBy('c.id_candidature', 'DESC')->getQuery()->getResult() as $candidature) {
            if (!$candidature instanceof Candidature) {
                continue;
            }

            $label = sprintf('#%d - %s', $candidature->getIdCandidature(), $candidature->getStatut() ?? 'Sans statut');
            $candidatureChoices[$label] = $candidature->getIdCandidature();
        }

        $utilisateurChoices = [];
        foreach ($this->userRepository->createQueryBuilder('u')->orderBy('u.prenom', 'ASC')->getQuery()->getResult() as $user) {
            if (!$user instanceof User) {
                continue;
            }

            $label = trim(($user->getPrenom() ?? '') . ' ' . ($user->getNom() ?? ''));
            $label = trim($label) !== '' ? $label : 'Utilisateur';
            $utilisateurChoices[sprintf('%s (%s)', $label, $user->getEmail() ?? 'email inconnu')] = $user->getId();
        }

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
            ->add('idCandidature', ChoiceType::class, [
                'choices' => $candidatureChoices,
                'required' => false,
                'placeholder' => '-- Choisir une candidature --',
                'label' => 'Candidature',
            ])
            ->add('idUtilisateur', ChoiceType::class, [
                'choices' => $utilisateurChoices,
                'required' => false,
                'placeholder' => '-- Choisir un utilisateur --',
                'label' => 'Utilisateur',
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
