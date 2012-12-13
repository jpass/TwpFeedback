<?php

namespace Twp\Bundle\IssueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Entity\Issue;
use Twp\Entity\Status;

class IssueController extends Controller
{
    public function addAction(Issue $issue)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $issue->setUser($user);
        $issue->addAffectedUser($user);
        
        $status = new Status();
        $status->setUser($user);
        $status->setIssue($issue);
        $em->persist($status);
        
        $issue->addStatus($status);
        $em->persist($issue);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('issue_show', array('id' => $issue->getId())));
    }
    
    /**
     * @Route("/issue/{id}", name="issue_show", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction($id)
    {
        $issue = $this->getDoctrine()->getRepository('Twp:Issue')->findOneWthComments($id);
        
        $commentForm = $this->get('commentController')->formAction();
        
        // check if its admin form
        if(isset($commentForm['status']))
        {
            $commentForm['status']->setData($issue->getCurrentStatus()->getType());
        }
        
        if($this->getRequest()->isMethod('POST'))
        {
            $commentForm->bind($this->getRequest());
            if ($commentForm->isValid()) 
            {
                $em = $this->getDoctrine()->getManager();
                $user = $this->get('security.context')->getToken()->getUser();
                $comment = $commentForm->getData();
                $comment->setUser($user);
                $comment->setIssue($issue);
                $em->persist($comment);
                if(isset($commentForm['change_status']) && $commentForm['change_status']->getData())
                {
                    $status = new Status($commentForm['status']->getData());
                    $status->setUser($user);
                    $status->setIssue($issue);
                    $status->setComment($comment);
                    $em->persist($status);
                    
                    $issue->addStatus($status);
                    $em->persist($issue);
                }
                $em->flush();
                
                return $this->redirect($this->generateUrl('issue_show', array('id' => $id)));
            }
        }
        
        return array('issue' => $issue, 'commentForm' => $commentForm->createView());
    }
    
    /**
     * @Route("/issue")
     * @Template()
     */
    public function listAction()
    {
        return array('issues' => $this->getDoctrine()->getRepository('Twp:Issue')->findAll());
    }
    
    /**
     * @Route("/issue/{id}/mark", name="issue_mark")
     */
    public function markAction($id)
    {
        $issue = $this->getDoctrine()->getRepository('Twp:Issue')->findOneById($id);
        
        if(!$issue)
        {
            throw $this->createNotFoundException('Issue not found');
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $marked = $issue->getAffectedUsers()->contains($user);
        
        if(!$marked)
        {
            $issue->getAffectedUsers()->add($user);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($issue);
            $em->flush();
        }
        
         return $this->redirect($this->generateUrl('issue_show', array('id' => $issue->getId())));
    }
    
    /**
     * @Route("/issue/{id}/unmark", name="issue_unmark")
     */
    public function unmarkAction($id)
    {
        $issue = $this->getDoctrine()->getRepository('Twp:Issue')->findOneById($id);
        
        if(!$issue)
        {
            throw $this->createNotFoundException('Issue not found');
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $issue->getAffectedUsers()->removeElement($user);
        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();
        
        return $this->redirect($this->generateUrl('issue_show', array('id' => $issue->getId())));
    }
}
