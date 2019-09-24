<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/api/buscador/recetas", name="buscadorRecetasAPI", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    public function buscadorRecetasAPIAction(Request $request)
    {

        $search = $request->query->get('q');
        $page = $request->query->get('p');

        if(is_null($search)){
            return new JsonResponse([
                'status' => 404,
                'message' => 'No se ha encontrado ningún parámetro de búsqueda',
                'data' => []
            ], 200);
        }

        try {

            if(is_null($page) || $page == 0){
                $response = $this->client->request('GET', '?q='.$search);
                $page = 1;
            } else{
                $response = $this->client->request('GET', '?q='.$search.'&p='.$page);
            }

        } catch (RequestException $e) {
            return new JsonResponse([
                'status' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ], 200);
        }

        if($response->getStatusCode() == 200){
            $resultados = json_decode($response->getBody()->getContents())->results;

            return new JsonResponse([
                'status' => 200,
                'message' => 'OK',
                'data' => $resultados,
                'next_page' => 'http://localhost:8000/api/buscador/recetas?q='.$search.'&p='.++$page
            ], 200);

        }else{

            return new JsonResponse([
                'status' => 500,
                'message' => 'Error al realizar la petición.',
                'data' => []
            ], 200);
        }

    }

    /**
     * @Route("/api/listado/recetas", name="listadoRecetasAPI", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    public function listadoRecetasAPIAction(Request $request)
    {

        $page = $request->query->get('p');

        try {

            if(is_null($page) || $page == 0){
                $response = $this->client->request('GET', '');
                $page = 1;
            } else{
                $response = $this->client->request('GET', '?p='.$page);
            }

        } catch (RequestException $e) {

            return new JsonResponse([
                'status' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ], 200);

        }

        if($response->getStatusCode() == 200){
            $resultados = json_decode($response->getBody()->getContents())->results;

            return new JsonResponse([
                'status' => 200,
                'message' => 'OK',
                'data' => $resultados,
                'next_page' => 'http://localhost:8000/api/listado/recetas?p='.++$page
            ], 200);

        }else{
            return new JsonResponse([
                'status' => 500,
                'message' => 'Error al realizar la petición.',
                'data' => []
            ], 200);
        }
    }
}
