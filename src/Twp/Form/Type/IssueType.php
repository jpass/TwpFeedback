<?php

namespace Twp\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Enter your issue...'))
            ->add('content', null, array('label' => 'Describe your issue... '));
    }

    public function getName()
    {
        return 'issue';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Twp\Entity\Issue',
        ));
    }
}