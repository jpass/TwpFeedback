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

class ApiController extends Controller
{
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