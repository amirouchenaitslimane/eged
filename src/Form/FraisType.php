<?php

namespace App\Form;

use App\Entity\Frais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,[
              'widget' => 'single_text',
              'format' => 'dd-MM-yyyy',
              'html5' => false,
              'attr' => ['class' => 'datetimepicker1'],
            ])
            ->add('libelle')
          ->add('type',ChoiceType::class,[
            'choices'  => [
              'Repas personnel' => 'repas_personelle',
              'Repas professionnel' => 'repas_proff',
              'Transport' => 'transport',
              'Achat professionnel'=>'achat_professionnel',
              'Cadeau client'=>'cadeau_client'
            ],
          ])
            ->add('montant_ttc',NumberType::class)
            ->add('montant_ht',NumberType::class)
            ->add('fichier',FileType::class,[

              'required'=>false,

            ])
            ->add('taxe',NumberType::class)

          ->add('submit',SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frais::class,


        ]);
    }
}
