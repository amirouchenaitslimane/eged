<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
          ->add('date',DateType::class,[
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'html5' => false,
            'attr' => ['class' => 'datetimepicker1'],
          ])
            ->add('type',ChoiceType::class,[
              'choices'=>$this->getType(),
            ])
            ->add('file',FileType::class,[
              'required'=>false,
            ])

          ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }

  private function getType()
  {
    $types = Document::TYPE;
    $sortie = [];
    foreach ($types as $key=> $type) {
      $sortie[$type] = $key;
    }
    return $sortie;
  }
}
