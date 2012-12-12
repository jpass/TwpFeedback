<?php

namespace Twp\Bundle\IdeaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Entity\Idea;
use Twp\Entity\Vote;

class IdeaController extends Controller
{
    public function addAction(Idea $idea, $votes)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $idea->setUser($user);
        
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
        
        $commentForm = $this->get('commentController')->formAction();
        
        if($this->getRequest()->isMethod('POST'))
        {
            $commentForm->bind($this->getRequest());
            if ($commentForm->isValid()) 
            {
                $commentForm->getData()->setIdea($idea);
                $this->get('commentController')->addAction($commentForm->getData());
                return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
            }
        }
        
        return array('idea' => $idea, 'commentForm' => $commentForm->createView());
    }
    
    /**
     * @Route("/idea")
     * @Template()
     */
    public function listAction()
    {
        return array('ideas' => $this->getDoctrine()->getRepository('Twp:Idea')->findAll());
    }
    
    /**
     * @Route("/idea/{id}/vote/{votes}", requirements={"id" = "\d+", "votes" = "[0-3]"}, name="idea_vote")
     */
    public function voteAction($id, $votes)
    {       
        $user = $this->get('security.context')->getToken()->getUser();
        
        if(!$user->getRemainingVotes())
        {
            // someone is cheating
            throw new \Exception('You have no more votes');
        }
        
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);
        
        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        
        // if user voted for this idea before we ensure we only add new votes or remove old ones
        $votedCount = $this->getDoctrine()->getRepository('Twp:Vote')->findBy(array('user' => $user->getId(), 'idea' => $id));
        $votes = $votes - count($votedCount);
        
        // remove unwanted votes
        for($i = 0; $i < ($votes * -1); $i++)
        {
            $em->remove($votedCount[$i]);
        }
        
        // or add more
        for($i = 0; $i < $votes; $i++)
        {
            $vote = new Vote();
            $vote->setUser($user);
            $vote->setIdea($idea);
            $em->persist($vote);
        }
        $em->flush();        
        
        return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
    }
}
