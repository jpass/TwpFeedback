<?php

namespace Twp\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Form\Type\IdeaType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->createForm(new IdeaType());
        
        if($this->getRequest()->isMethod('POST'))
        {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                return $this->forward('TwpIdeaBundle:Idea:add', array('idea' => $form->getData(), 'votes' => $form->get('votes')->getData()));
            }
        }
        
        return array('form' => $form->createView(), 'topIdeas' => $this->getDoctrine()->getRepository('Twp:Idea')->getTop());
    }
}
