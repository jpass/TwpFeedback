<?php

namespace Twp\Bundle\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Form\Type\CommentType;
use Twp\Entity\Comment;

use Symfony\Component\DependencyInjection\ContainerInterface;

class CommentController extends Controller
{
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function formAction()
    {
        $form = $this->container
                ->get('form.factory')
                ->create(new CommentType($this->get('security.context')->isGranted('ROLE_FEEDBACK_ADMIN')));
        
        return $form;
    }
    
    public function addAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $em->persist($comment);
        $em->flush();
        
        return;
    }
}
