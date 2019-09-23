<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

        try {
            $response = $this->client->request('GET', '?q='.$search);
        } catch (RequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if($response->getStatusCode() == 200){
            $resultados = json_decode($response->getBody()->getContents())->results;

            return new JsonResponse($resultados, 200);
        }else{
            throw new BadRequestHttpException('Error al realizar la petición.');
        }

    }

    /**
     * @Route("/api/listado/recetas", name="listadoRecetasAPI", methods={"GET"})
     * @return Response
     * @throws GuzzleException
     */
    public function listadoRecetasAPIAction()
    {

        try {
            $response = $this->client->request('GET', '');
        } catch (RequestException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if($response->getStatusCode() == 200){
            $resultados = json_decode($response->getBody()->getContents())->results;

            return new JsonResponse($resultados, 200);
        }else{
            throw new BadRequestHttpException('Error al realizar la petición.');
        }
    }
}
