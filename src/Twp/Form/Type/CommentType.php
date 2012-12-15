<?php

namespace Twp\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    protected $isAdmin;
    
    public function __construct($isAdmin = false) {
        $this->isAdmin = $isAdmin;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', null, array(
                'label' => 'New Comment',
                'attr' => array('placeholder' => 'Add a comment...')
                ));
        if($this->isAdmin)
        {
            $builder->add('change_status', 'checkbox', array(
                'mapped' => false,
                'label' => 'Change status?',
                'required' => false
            ));
            $builder->add('status', 'choice', array(
                'mapped' => false,
                'label' => '',
                'choices' => \Twp\Entity\Status::getChoices(),
                'required' => false
            ));
        }
    }

    public function getName()
    {
        return 'comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Twp\Entity\Comment',
        ));
    }
}