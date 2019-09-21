<?php

namespace App\Controller;

use App\Form\Type\BuscadorRecetasType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetasController extends AbstractController
{
    /**
     * @Route("/recetas/buscador", name="buscadorRecetas")
     * @param Request $request
     * @return Response
     */
    public function buscadorAction(Request $request)
    {
        $form = $this->createForm(BuscadorRecetasType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $respuesta = $this->forward('App\Controller\ApiController::buscadorRecetasAPIAction', [
                'nombre' => $form->get('buscador')->getData(),
            ]);

            return $this->render('recetas/buscador.html.twig', [
                'form' => $form->createView(),
                'respuesta' => json_decode($respuesta->getContent(), true)
            ]);
        }

        return $this->render('recetas/buscador.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recetas/listado", name="listadoRecetas")
     * @param Request $request
     * @return Response
     */
    public function listadoAction(Request $request)
    {
        $respuesta = $this->forward('App\Controller\ApiController::listadoRecetasAPIAction');

        return $this->render('recetas/listado.html.twig', [
            'respuesta' => json_decode($respuesta->getContent(), true)
        ]);
    }
}
