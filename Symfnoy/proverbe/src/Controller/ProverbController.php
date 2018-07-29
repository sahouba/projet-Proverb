<?php

namespace App\Controller;

use App\Entity\Proverb;
use App\Form\ProverbType;
use App\Repository\ProverbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proverb")
 */
class ProverbController extends Controller
{
    /**
     * @Route("/", name="proverb_index", methods="GET")
     */
    public function index(ProverbRepository $proverbRepository): Response
    {
        return $this->render('proverb/index.html.twig', ['proverbs' => $proverbRepository->findAll()]);
    }

    /**
     * @Route("/new", name="proverb_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $proverb = new Proverb();
        $form = $this->createForm(ProverbType::class, $proverb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proverb);
            $em->flush();

            return $this->redirectToRoute('proverb_index');
        }

        return $this->render('proverb/new.html.twig', [
            'proverb' => $proverb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proverb_show", methods="GET")
     */
    public function show(Proverb $proverb): Response
    {
        return $this->render('proverb/show.html.twig', ['proverb' => $proverb]);
    }

    /**
     * @Route("/{id}/edit", name="proverb_edit", methods="GET|POST")
     */
    public function edit(Request $request, Proverb $proverb): Response
    {
        $form = $this->createForm(ProverbType::class, $proverb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proverb_edit', ['id' => $proverb->getId()]);
        }

        return $this->render('proverb/edit.html.twig', [
            'proverb' => $proverb,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proverb_delete", methods="DELETE")
     */
    public function delete(Request $request, Proverb $proverb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proverb->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proverb);
            $em->flush();
        }

        return $this->redirectToRoute('proverb_index');
    }
}
