<?php

namespace App\Controller;

use App\Entity\Dons;
use App\Entity\Demand;
use App\Form\DonsType;
use App\Repository\DonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Security\Core\Security;

#[Route('/dons')]
class DonsController extends AbstractController
{
    #[Route('/{iddemand}', name: 'app_dons_index', methods: ['GET'])]
    public function index(DonsRepository $donsRepository, int $iddemand): Response
    {
        $dons = $donsRepository->findAll();

        return $this->render('dons/index.html.twig', [
            'dons' => $dons,
            'iddemand' => $iddemand,
        ]);
    }



    #[Route('/new/{iddemand}', name: 'app_dons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $iddemand, Security $security): Response
    {
        $demand = $this->getDoctrine()->getRepository(Demand::class)->find($iddemand);
        if (!$demand) {
            throw $this->createNotFoundException('Demand not found');
        }

        $don = new Dons();
        $don->setIddemand($demand);



        $form = $this->createForm(DonsType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($don);
            $entityManager->flush();

            return $this->redirectToRoute('app_dons_index', ['iddemand' => $iddemand]);
        }

        return $this->render('dons/new.html.twig', [
            'form' => $form->createView(),
            'iddemand' => $iddemand,
        ]);
    }

    #[Route('/{id}', name: 'app_dons_show', methods: ['GET'])]
    public function show(int $id, DonsRepository $donsRepository): Response
    {
        $donation = $donsRepository->find($id);

        if (!$donation) {
            throw $this->createNotFoundException('Donation not found');
        }

        return $this->render('dons/show.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DonsType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dons_index');
        }

        return $this->renderForm('dons/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dons_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, Dons $don, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $don->getIdDons(), $request->request->get('_token'))) {
            $entityManager->remove($don);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dons_index');
    }
}
