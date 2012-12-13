<?php

use Liip\FunctionalTestBundle\Test\WebTestCase;

class MyControllerTest extends WebTestCase
{
    
    public function setUp()
    {
        $this->loadFixtures(array('Twp\Tests\DataFixtures\ORM\LoadUserData'));
    }
    
    public function testDasboard()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($crawler->filter('h2:contains("I suggest you...")')->count() > 0);
        
        // check form
        $this->assertTrue($crawler->filter('#idea_title')->count() > 0);
        $this->assertTrue($crawler->filter('#idea_content')->count() > 0);
        $this->assertTrue($crawler->filter('#idea_votes')->count() > 0);
        $this->assertTrue($crawler->filter('#idea__token')->count() > 0);
        $this->assertTrue($crawler->filter('input[value="Add"]')->count() > 0);
    }
    
    public function testTopIdeas()
    {
        $this->loadFixtures(array(
            'Twp\Tests\DataFixtures\ORM\LoadUserData',
            'Twp\Tests\DataFixtures\ORM\LoadIdeaData'));
        
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($crawler->filter('.idea header a:contains("IdeaTest1 Titile")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea section:contains("IdeaTest1 Content")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea footer:contains("new")')->count() > 0);
        
        $this->assertTrue($crawler->filter('.votes-count strong:contains("0")')->count() > 0);
        $this->assertTrue($crawler->filter('.votes-count span:contains("Vote")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea .vote > span:contains("Vote")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea .vote > a:contains("Sign in to vote")')->count() > 0);
        
    }
}