<?php

namespace Twp\Bundle\IdeaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Entity\Idea;

class IdeaController extends Controller
{
    public function addAction(Idea $idea, $votes)
    {
        $em = $this->getDoctrine()->getManager();
        // TODO: setUser
        $em->persist($idea);
        $em->flush();
        
        $this->voteAction($idea->getId(), $votes);
        
        return $this->redirect($this->generateUrl('idea_show', array('id' => $idea->getId())));
    }
    
    /**
     * @Route("/idea/{id}", name="idea_show", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction($id)
    {
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneWthComments($id);
        
        return array('idea' => $idea);
    }
    
    /**
     * @Route("/idea")
     * @Template()
     */
    public function listAction()
    {
        return array('ideas' => $this->getDoctrine()->getRepository('Twp:Idea')->findAll());
    }
    
    public function voteAction($id, $votes)
    {
        if(!$votes)
        {
            throw new \Exception('Trying to add 0 votes');
        }
        
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);
        
        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }
        
        return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
    }
}
