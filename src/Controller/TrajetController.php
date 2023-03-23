<?php

namespace App\Controller;

use App\Entity\utilisateur;
use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use Faker\Core\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/trajet")
 */
class TrajetController extends AbstractController
{
    /**
     * @Route("/", name="app_trajet_index", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_ADMIN for  method create in this class
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(TrajetRepository $trajetRepository): Response
    {
        return $this->render('trajet/index.html.twig', [
            'trajets' => $trajetRepository->findAllTrajet(),
        ]);
    }

    /**
     * @Route("/futur", name="app_trajet_a_venir", methods={"GET"})
     */
    public function trajetAVenir (TrajetRepository $trajetRepository) : Response
    {
        return $this->render('trajet/index.html.twig', [
            'trajets' => $trajetRepository->findAllGreaterThanDateNow(),
        ]);
    }
    /**
     * @Route("/new", name="app_trajet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TrajetRepository $trajetRepository): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_trajet_index';
        }
        else {$route = 'app_trajet_a_venir';}

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $trajet->setIdUtilisateurAuteur($user);
            $trajetRepository->add($trajet);
            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trajet/new.html.twig', [
            'trajet' => $trajet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_trajet_show", methods={"GET"})
     */
    public function show(Trajet $trajet): Response
    {
        return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_trajet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trajet $trajet, TrajetRepository $trajetRepository): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_trajet_index';
        }
        else {$route = 'app_trajet_a_venir';}


        if ($form->isSubmitted() && $form->isValid()) {
            $trajetRepository->add($trajet);
            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trajet/edit.html.twig', [
            'trajet' => $trajet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_trajet_delete", methods={"POST"})
     */
    public function delete(Request $request, Trajet $trajet, TrajetRepository $trajetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trajet->getId(), $request->request->get('_token'))) {
            $trajetRepository->remove($trajet);
        }

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_trajet_index';
        }
        else {$route = 'app_trajet_a_venir';}

        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }

}
