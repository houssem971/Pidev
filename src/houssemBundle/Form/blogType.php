<?php

namespace houssemBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class blogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('description')
            ->add('dateAjout',DateType::class)
            ->add('image1', FileType::class, array(
                'label' => 'ajouter image',
                'data_class' => null
            ))
            ->add('image2', FileType::class, array(
                'label' => 'ajouter image',
                'data_class' => null
            ))
            ->add('image3', FileType::class, array(
                'label' => 'ajouter image',
                'data_class' => null
            ))
        ->add('categorie',EntityType::class,[
        'class'=>'houssemBundle:categorie',
        'choice_label'=>'nom',
    ])
         ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'houssemBundle\Entity\blog'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'houssembundle_blog';
    }


}
