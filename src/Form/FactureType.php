<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Facture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class,
              [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker1'],
              ]
              )
            ->add('date_debut', DateType::class,
              [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker1'],
              ]
            )
            ->add('date_fin', DateType::class,
              [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => ['class' => 'datetimepicker_debut'],
              ]
              )
            ->add('etat',ChoiceType::class,[
              'choices'=>$this->getEtat()
            ])
            ->add('designation',TextareaType::class)
            ->add('quantite',NumberType::class)
            ->add('prix_unitaire',NumberType::class)

//            ->add('totalTva')
//            ->add('totalTtc')
            ->add('client',EntityType::class,[
            'class' => Client::class,
            'choice_label' => 'nom',
            'attr' => ['class'=>'select2 form-control']

          ])
          ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }

  private function getEtat()
  {
    $etats   = Facture::ETAT;
    $sortie  = [];
    foreach ($etats as $cle=> $etat) {
      $sortie[$etat]  =  $cle;
    }

    return $sortie;
  }
}
