<?php

namespace Twp\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Twp\Form\Type\IdeaType;
use Symfony\Component\Security\Core\SecurityContext;

use \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
    
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $this->get('session');
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        );
    }
    
    /**
     * @Route("/api/login/{id}")
     */
    public function loginUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('Twp:User')->findOneById($id);
        if(!$user)
        {
            throw $this->createNotFoundException('User not found');
        }
        
        $token = new UsernamePasswordToken($user, null, 'login_firewall', $user->getRoles());
        $this->get('security.context')->setToken($token);
        
        return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     * @Route("/api/logout")
     */
    public function logoutUserAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        
        return $this->redirect($this->generateUrl('homepage'));
    }
}
