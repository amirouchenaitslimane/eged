<?php

namespace App\Form\Security;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add('nom',TextType::class)
        ->add('prenom',TextType::class)
        ->add('email',EmailType::class)
        ->add('username',TextType::class)
        ->add('password',PasswordType::class,[
          'required'   => false,
          'empty_data' => '',

        ])
        ->add('roles', ChoiceType::class, array('choices' =>
          array(
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
          ),
          'mapped'=>false,
          'multiple' => true,
          'expanded'=>true,
          'required'=>false
        ))
        ->add('etat')
        ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
      ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
