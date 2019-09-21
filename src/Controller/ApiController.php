<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    protected $client;

    /**
     * ApiController constructor.
     * @param string $url
     */
    public function __construct($url = 'http://www.recipepuppy.com/api')
    {
        $this->client = new Client([
            'base_uri' => $url
        ]);
    }

    /**
     * @Route("/api/buscador/recetas/{nombre}", name="buscadorRecetasAPI", methods={"POST"})
     * @param string $nombre
     * @return Response
     * @throws GuzzleException
     */
    public function buscadorRecetasAPIAction($nombre)
    {

        $response = $this->client->request('GET', '?q='.$nombre);

        return new Response($response->getBody()->getContents());

    }

    /**
     * @Route("/api/listado/recetas", name="listadoRecetasAPI", methods={"GET"})
     * @return Response
     * @throws GuzzleException
     */
    public function listadoRecetasAPIAction()
    {

        $response = $this->client->request('GET', '');

        return new Response($response->getBody()->getContents());

    }
}
