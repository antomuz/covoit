<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Security $security
     * @return RedirectResponse|Response
     * Require ROLE_ADMIN for  method create in this class
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateur", name="app_commentaire_user", methods={"GET", "POST"})
     */
    public function commentairesUser(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/commentairesUser.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_commentaire_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_commentaire_index';
        }
        else {$route = 'app_commentaire_user';}

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $commentaire->setIdUtilisateurAuteur($user);
            $commentaireRepository->add($commentaire);
            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_commentaire_index';
        }
        else {$route = 'app_commentaire_user';}

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->add($commentaire);
            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $commentaireRepository->remove($commentaire);
        }

        if ($this->isGranted("ROLE_ADMIN")){
            $route = 'app_commentaire_index';
        }
        else {$route = 'app_commentaire_user';}

        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }
}
