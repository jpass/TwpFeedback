<?php

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DashboardTest extends WebTestCase
{

    public function setUp()
    {
        $this->loadFixtures(array('Twp\Tests\DataFixtures\ORM\LoadUserData'));
    }

    public function testDasboard()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('#dashboard-tabs a:contains("Add Idea")')->count() > 0);
        $this->assertTrue($crawler->filter('#dashboard-tabs a:contains("Add Issue")')->count() > 0);

        $this->assertTrue($crawler->filter('legend:contains("I suggest you...")')->count() > 0);

        // check form
        $this->assertTrue($crawler->filter('input#new_idea_title')->count() > 0);
        $this->assertTrue($crawler->filter('textarea#new_idea_content')->count() > 0);
        $this->assertTrue($crawler->filter('input#new_idea_title[placeholder="Enter your idea..."]')->count() > 0);
        $this->assertTrue($crawler->filter('textarea#new_idea_content[placeholder="Describe your idea..."]')->count() > 0);
        $this->assertTrue($crawler->filter('#new_idea_votes')->count() > 0);
        $this->assertTrue($crawler->filter('#new_idea__token')->count() > 0);
        $this->assertTrue($crawler->filter('input[value="Add"]')->count() > 0);
    }

    public function testTopIdeas()
    {
        $this->loadFixtures(array(
            'Twp\Tests\DataFixtures\ORM\LoadUserData',
            'Twp\Tests\DataFixtures\ORM\LoadIdeaData'));

        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('.idea h4 a:contains("IdeaTest1 Titile")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea p:contains("IdeaTest1 Content")')->count() > 0);
        $this->assertTrue($crawler->filter('.idea footer span.label:contains("new")')->count() > 0);

        $this->assertTrue($crawler->filter('.votes-count h4:contains("0")')->count() > 0);
        $this->assertTrue($crawler->filter('.votes-count:contains("Vote")')->count() > 0);
        //$this->assertTrue($crawler->filter('.idea .vote > span:contains("Vote")')->count() > 0);
        //$this->assertTrue($crawler->filter('.idea .vote > a:contains("Sign in to vote")')->count() > 0);

    }

    public function testLoginRedirectsToLoginForm()
    {
        $this->loadFixtures(array(
            'Twp\Tests\DataFixtures\ORM\LoadUserData',
            'Twp\Tests\DataFixtures\ORM\LoadIdeaData'));

        $client = static::createClient();

        $client->request('GET', '/idea');

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('input#username')->count() > 0);
        $this->assertTrue($crawler->filter('input#username')->count() > 0);
        $this->assertTrue($crawler->filter('button[type="submit"]:contains("login")')->count() > 0);
    }
}