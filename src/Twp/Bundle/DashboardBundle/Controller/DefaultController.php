<?php

namespace Twp\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Entity\Idea;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $idea = new Idea();
        $form = $this->createFormBuilder($idea)
            ->add('title', null, array('label' => 'Enter your idea...'))
            ->add('content', null, array('label' => 'Describe your idea...'))
            ->add('votes', 'choice', array(
                'choices' => array(1,2,3),
                'mapped' => false,
                'expanded' => true
                ))
            ->getForm();
        
        return array('form' => $form->createView());
    }
}
