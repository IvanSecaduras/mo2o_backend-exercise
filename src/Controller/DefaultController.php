<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="inicio")
     * @return Response
     */
    public function inicioAction()
    {
        return $this->render('inicio/index.html.twig');
    }

}
