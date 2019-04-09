<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Cra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,[
              'widget' => 'single_text',
              'format' => 'dd-MM-yyyy',
              'html5' => false,
              'attr' => ['class' => 'datetimepicker_cra'],
            ])
            ->add('journee',ChoiceType::class,
              [
                'choices'=>['0.25'=>'0.25','0.5'=>'0.5','0.75'=>'0.75','1'=>'1'],
                'required'=>true,
                'attr'=>['class'=>'form-control']
              ])
            ->add('client',EntityType::class,[
              'class'=>Client::class,
              'choice_label'=>'nom',
              'required'=>true,
              'attr'=>['class'=>'form-control']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cra::class,
        ]);
    }
}
