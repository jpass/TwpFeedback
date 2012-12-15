<?php

namespace Twp\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Twp\Form\Type\IdeaType;
use Twp\Form\Type\IssueType;
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
        $ideaForm = $this->get('form.factory')->createNamed('new_idea', new IdeaType());
        $issueForm = $this->get('form.factory')->createNamed('new_issue', new IssueType());
        
        if($this->getRequest()->isMethod('POST'))
        {
            $ideaForm->bind($this->getRequest()->get('new_idea'));
            $issueForm->bind($this->getRequest()->get('new_issue'));
            if ($ideaForm->isValid()) {
                return $this->forward('TwpIdeaBundle:Idea:add', array('idea' => $ideaForm->getData(), 'votes' => $ideaForm->get('votes')->getData()));
            }
            if ($issueForm->isValid()) {
                return $this->forward('TwpIssueBundle:Issue:add', array('issue' => $issueForm->getData()));
            }
        }
        
        return array(
            'ideaForm' => $ideaForm->createView(),
            'issueForm' => $issueForm->createView(),
            'topIdeas' => $this->getDoctrine()->getRepository('Twp:Idea')->getTop(),
            'topIssues' => $this->getDoctrine()->getRepository('Twp:Issue')->getTop()
                );
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

    /**
     * @Route("/rss", name="rss")
     * @Template()
     */
    public function feedAction()
    {
        $feed = array();

        $url = $this->container->getParameter('twp_dashboard.rss_feed');

        if(!$url)
        {
            return new Response();
        }

        $xml = new \SimpleXMLElement($url, null, true);

        foreach($xml->channel->item as $item)
        {
            $v = array();
            $v['title'] = $item->title.'';
            $v['link'] = $item->link.'';
            $v['description'] = $item->description.'';
            if(!isset($feed[$item->category.'']))
            {
                $feed[$item->category.''] = array();
            }
            $feed[$item->category.''][] = $v;
        }

        return array('feed' => $feed);
    }
}
