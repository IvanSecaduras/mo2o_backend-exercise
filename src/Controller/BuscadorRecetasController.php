<?php

namespace App\Controller;

use App\Form\Type\BuscadorRecetasType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuscadorRecetasController extends AbstractController
{
    /**
     * @Route("/buscador/recetas", name="buscadorRecetas")
     * @param Request $request
     * @return Response
     */
    public function buscadorRecetasAction(Request $request)
    {
        $form = $this->createForm(BuscadorRecetasType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $respuesta = $this->forward('App\Controller\ApiController::buscadorRecetasAPIAction', [
                'nombre' => $form->get('buscador')->getData(),
            ]);

            return $this->render('buscadorRecetas/index.html.twig', [
                'form' => $form->createView(),
                'respuesta' => json_decode($respuesta->getContent(), true)
            ]);
        }

        return $this->render('buscadorRecetas/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
