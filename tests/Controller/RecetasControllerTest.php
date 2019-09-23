<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecetasControllerTest extends WebTestCase
{

    public function testBuscadorAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recetas/buscador');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Buscar')->form();
        $form['buscador_recetas[buscador]'] = 'tortilla';

        $crawler = $client->submit($form);

        $this->assertCount(1, $crawler->filter('html h1:contains("Resultado:")'));
    }

    public function testListadoAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recetas/listado');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html div.card')->count());
    }

}
