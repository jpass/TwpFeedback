<?php

namespace Twp\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => ' ',
                'attr' => array('placeholder' => 'Enter your idea...')
                ))
            ->add('content', null, array(
                'label' => ' ',
                'attr' => array('placeholder' => 'Describe your idea...')
                ))
            ->add('votes', 'choice', array(
                'choices' => array(1 => 1, 2 => 2, 3 => 3),
                'mapped' => false,
                'expanded' => true,
                'data' => 1
                ));
    }

    public function getName()
    {
        return 'idea';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Twp\Entity\Idea',
        ));
    }
}