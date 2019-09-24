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
        $this->assertEquals(200, json_decode($client->getResponse()->getContent())->status);
        $this->assertEquals('OK', json_decode($client->getResponse()->getContent())->message);
        $this->assertGreaterThan(0, count(json_decode($client->getResponse()->getContent())->data));

        $client->request('GET', '/api/buscador/recetas?t=tortilla');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(404, json_decode($client->getResponse()->getContent())->status);
        $this->assertEquals('No se ha encontrado ningún parámetro de búsqueda', json_decode($client->getResponse()->getContent())->message);
        $this->assertEquals(0, count(json_decode($client->getResponse()->getContent())->data));

        $client->request('GET', '/api/buscador/recetas?q=tortilla&p=5');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(200, json_decode($client->getResponse()->getContent())->status);
        $this->assertEquals('OK', json_decode($client->getResponse()->getContent())->message);
        $this->assertGreaterThan(0, count(json_decode($client->getResponse()->getContent())->data));

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
        $this->assertEquals(200, json_decode($client->getResponse()->getContent())->status);
        $this->assertEquals('OK', json_decode($client->getResponse()->getContent())->message);
        $this->assertGreaterThan(0, count(json_decode($client->getResponse()->getContent())->data));
    }

}
