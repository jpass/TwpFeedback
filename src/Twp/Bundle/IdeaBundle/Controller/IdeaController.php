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
        
        //return $this->redirect();
        return new \Symfony\Component\HttpFoundation\Response();
    }
}
