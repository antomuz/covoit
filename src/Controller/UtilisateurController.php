<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * Lister tous les utilisateurs.
     * @Route("/utilisateur/", name="utilisateur.list")
     * @return Response
     */
    public function list() : Response
    {
        $utilisateurs = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        print ("bonjour");
        return $this->render('utilisateur/list.html.twig', [
            'utilisateur' => $utilisateurs,
        ]);
    }

    /**
     * Chercher et afficher un utilisateur.
     * @Route("/utilisateur/{id}", name="utilisateur.show", requirements={"id" = "\d+"})
     * @param Utilisateur $utilisateur
     * @return Response
     */
    public function show(Utilisateur $utilisateur) : Response
    {
        return $this->render('stage/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
}
