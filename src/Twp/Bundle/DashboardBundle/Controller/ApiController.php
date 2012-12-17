<?php

namespace Twp\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Twp\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

use \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/api")
 */

class ApiController extends Controller
{
    /**
     * @Route("/login/{id}", name="api_login")
     */
    public function loginUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('Twp:User')->findOneByGlueId($id);
        if(!$user)
        {
            throw $this->createNotFoundException('User not found');
        }

        $token = new UsernamePasswordToken($user, null, 'login_firewall', $user->getRoles());
        $this->get('security.context')->setToken($token);

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/logout")
     */
    public function logoutUserAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/add-user")
     */
    public function addUserAction()
    {
        $request = $this->getRequest();
        $userInfo = $request->get('user');

        $user = $this->getDoctrine()->getRepository('Twp:User')->findOneByGlueId($userInfo['id']);

        if(!$user)
        {
            $user = new User();
            $user->setGlueId($userInfo['id']);
        }

        //echo 'aaaaaaaaaaaa'.$userInfo['name'].'aaaaaaaa';
        $user->setName($userInfo['name']);
        $user->setSalt($userInfo['salt']);
        $user->setPassword($userInfo['passpord']);
        $user->setEmail($userInfo['email']);
        $user->setRoles($userInfo['roles']);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('api_login', array('id' => $user->getGlueId())));
    }

}