<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{

    public function testBuscadorRecetasAPI()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/buscador/recetas?q=tortilla');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/buscador/recetas?q=tortilla');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/buscador/recetas?q=tortilla');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testlistadoRecetasAPI()
    {
        $client = static::createClient();

        $client->request('PUT', '/api/listado/recetas');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/listado/recetas');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());

        $client->request('GET', '/api/listado/recetas');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}
