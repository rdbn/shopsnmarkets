<?php

namespace Platform\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
        $this->assertContains('<div class="jumbotron bottom20">', $client->getResponse()->getContent());
    }

    public function testShops()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/shops');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
        $this->assertContains('<div class="media">', $client->getResponse()->getContent());
    }

    public function testProducts()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
        $this->assertContains('add-like-product', $client->getResponse()->getContent());
    }

    public function testProduct()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products/1');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
        $this->assertContains('img-thumbnail', $client->getResponse()->getContent());
    }
}
