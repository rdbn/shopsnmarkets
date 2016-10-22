<?php

namespace Platform\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
    public function testShops()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/showShops/20');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
    }

    public function testProducts()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/showProducts/20');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
    }

    public function testSearch()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/resultSearch');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
    }
}
