<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Form\DemandType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demand')]
class DemandController extends AbstractController
{
    #[Route('/', name: 'app_demand_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchQuery = $request->query->get('search');
        $sort = $request->query->get('sort');

        $queryBuilder = $entityManager->getRepository(Demand::class)->createQueryBuilder('d');

        if ($searchQuery) {
            $queryBuilder->andWhere('d.iddemand = :searchQuery')
                ->setParameter('searchQuery', $searchQuery);
        }; 

        if ($sort) {
            $queryBuilder->orderBy('d.iddemand', $sort);
        }

        $demands = $queryBuilder->getQuery()->getResult();

        return $this->render('demand/index.html.twig', [
            'demands' => $demands,
        ]);
    }

    #[Route('/new', name: 'app_demand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demand);
            $entityManager->flush();

            return $this->redirectToRoute('app_demand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demand/new.html.twig', [
            'demand' => $demand,
            'form' => $form,
        ]);
    }

    #[Route('/{iddemand}', name: 'app_demand_show', methods: ['GET'])]
    public function show(Demand $demand): Response
    {
        return $this->render('demand/show.html.twig', [
            'demand' => $demand,
        ]);
    }

    #[Route('/{iddemand}/edit', name: 'app_demand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demand $demand, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demand/edit.html.twig', [
            'demand' => $demand,
            'form' => $form,
        ]);
    }

    #[Route('/{iddemand}', name: 'app_demand_delete', methods: ['POST'])]
    public function delete(Request $request, Demand $demand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demand->getIddemand(), $request->request->get('_token'))) {
            $entityManager->remove($demand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demand_index', [], Response::HTTP_SEE_OTHER);
    }
    
}

