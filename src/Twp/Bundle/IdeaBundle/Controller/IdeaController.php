<?php

namespace Twp\Bundle\IdeaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Bundle\IdeaBundle\Form\Type\IdeaType;

class IdeaController extends Controller
{
    public function addAction($idea)
    {
        $em = $this->getDoctrine()->getManager();
        // TODO: setUser
        $em->persist($idea);
        $em->flush();
        
        return $this->redirect($this->generateUrl('idea_show', array('id' => $idea->getId())));
    }
    
    /**
     * @Route("/idea/{id}", name="idea_show", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction($id)
    {
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);
        
        return array('idea' => $idea);
    }
}
