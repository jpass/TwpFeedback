<?php

namespace Twp\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twp\Entity\Status;
use Twp\Entity\Idea;

use Doctrine\Common\Persistence\ObjectManager;

class LoadIdeaData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {   
        $user = $manager->merge($this->getReference('user'));
        
        $idea = new Idea();
        $idea->setUser($user);
        $idea->setTitle('IdeaTest1 Titile');
        $idea->setContent('IdeaTest1 Content');
        
        $manager->persist($idea);
        
        $status = new Status();
        $status->setUser($user);
        $status->setIdea($idea);
        
        $manager->persist($status);
        
        $idea->addStatus($status);
        $manager->persist($idea);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}