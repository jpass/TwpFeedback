<?php

namespace Twp\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twp\Entity\User;

use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setGlueId(1);
        $user->setIsActive(true);
        $user->setName('Johnny Mnemonic');
        $user->setEmail('test');
        $user->setPassword('test');
        
        $factory = $this->container->get('security.encoder_factory');

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);
        
        $manager->persist($user);
        $manager->flush(); 
        
        $this->addReference('user', $user);
        
        $user = new User();
        $user->setGlueId(1);
        $user->setIsActive(true);
        $user->setName('Johnny Mnemonic');
        $user->setEmail('admin');
        $user->setPassword('test');
        $user->setRoles(array('ROLE_FEEDBACK_ADMIN'));
        
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);
        
        $manager->persist($user);
        $this->addReference('admin-user', $user);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}