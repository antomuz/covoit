<?php

namespace App\Controller;

use App\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    /**
     * Lister tous les trajets.
     * @Route("/trajet/", name="trajet.list")
     * @return Response
     */
    public function list() : Response
    {
        $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll();
        return $this->render('trajet/list.html.twig', [
            'trajets' => $trajets,
        ]);
    }




}
