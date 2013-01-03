<?php

namespace Twp\Bundle\IdeaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Entity\Idea;
use Twp\Entity\Vote;
use \Twp\Entity\Status;
use \Twp\Entity\Watch;

class IdeaController extends Controller
{
    public function addAction(Idea $idea, $votes)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $idea->setUser($user);

        $status = new Status();
        $status->setUser($user);
        $status->setIdea($idea);
        $em->persist($status);

        $idea->addStatus($status);
        $em->persist($idea);

        $watch = new Watch();
        $watch->setUser($user)->setIdea($idea);
        $em->persist($watch);

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
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneWithComments($id);

        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }

        $commentForm = $this->get('commentController')->formAction();

        // check if its admin form
        if(isset($commentForm['status']))
        {
            $commentForm['status']->setData($idea->getCurrentStatus()->getType());
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
                $comment->setIdea($idea);
                $em->persist($comment);
                if(isset($commentForm['change_status']) && $commentForm['change_status']->getData())
                {
                    $status = new Status($commentForm['status']->getData());
                    $status->setUser($user);
                    $status->setIdea($idea);
                    $status->setComment($comment);
                    $em->persist($status);

                    if($status->isClosing())
                    {
                        // count votes
                        $idea->setClosingVotes($idea->getVotes()->count());
                        // free votes
                        foreach($idea->getVotes() as $vote)
                        {
                            $em->remove($vote);
                        }
                    }
                    $idea->addStatus($status);
                    $em->persist($idea);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
            }
        }

        return array('idea' => $idea, 'commentForm' => $commentForm->createView());
    }

    /**
     * @Route("/idea", name="idea_list")
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


        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);

        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }

        $em = $this->getDoctrine()->getEntityManager();

        // if user voted for this idea before we ensure we only add new votes or remove old ones
        $votedCount = $this->getDoctrine()->getRepository('Twp:Vote')->findBy(array('user' => $user->getId(), 'idea' => $id));

        if(($user->getRemainingVotes() + count($votedCount)) < 1)
        {
            // someone is cheating
            throw new \Exception('You have no more votes');
        }

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

        return $this->forward('TwpIdeaBundle:Idea:'.($votes > 0 ? 'watch' : 'unwatch') , array('id' => $id));
    }

    /**
     * @Route("/idea/{id}/watch", name="idea_watch")
     */
    public function watchAction($id)
    {
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);

        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }

        $user = $this->get('security.context')->getToken()->getUser();

        $watch = $this->getDoctrine()->getRepository('Twp:Watch')->findOneBy(array('user' => $user, 'idea' => $idea));

        if(!$watch)
        {
            $watch = new Watch();
            $watch->setUser($user)->setIdea($idea);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($watch);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
    }

    /**
     * @Route("/idea/{id}/unwatch", name="idea_unwatch")
     */
    public function unwatchAction($id)
    {
        $idea = $this->getDoctrine()->getRepository('Twp:Idea')->findOneById($id);

        if(!$idea)
        {
            throw $this->createNotFoundException('Idea not found');
        }

        $user = $this->get('security.context')->getToken()->getUser();

        $watch = $this->getDoctrine()->getRepository('Twp:Watch')->findOneBy(array('user' => $user, 'idea' => $idea));

        if($watch)
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($watch);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
    }
}
