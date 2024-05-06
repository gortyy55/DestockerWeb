<?php

namespace App\Controller;

use App\Entity\Enchere2;
use App\Form\EnchereType;
use App\Repository\Enchere2Repository;
use App\Repository\LotRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/enchere')]
class Enchere2Controller extends AbstractController
{



    #[Route('/', name: 'app_enchere_index', methods: ['GET'])]
    public function index(Enchere2Repository $enchereRepository, Request $request): Response
    {
        $searchQuery = $request->query->get('q');

        if ($searchQuery) {
            // Filter enchères by name if search query is provided
            $encheres = $enchereRepository->createQueryBuilder('e')
                ->andWhere('e.nom LIKE :search')
                ->setParameter('search', '%' . $searchQuery . '%')
                ->getQuery()
                ->getResult();
        } else {
            // Fetch all enchères if no search query is provided
            $encheres = $enchereRepository->findAll();
        }

        return $this->render('enchere/index.html.twig', [
            'encheres' => $encheres,
        ]);
    }

    #[Route('/listEnchere', name: 'app_listEnchere_index', methods: ['GET'])]
    public function listEnchere(Enchere2Repository $enchereRepository, LotRepository $lotRepository, ProduitRepository $produitRepository): Response
    {
        // Récupérer toutes les enchères
        $encheres = $enchereRepository->findAll();

        // Créer un tableau associatif pour stocker les lots associés à chaque enchère
        $lotsParEnchere = [];

        // Créer un tableau associatif pour stocker les produits associés à chaque enchère
        $produitsParEnchere = [];

        // Parcourir chaque enchère pour récupérer les lots et les produits associés
        foreach ($encheres as $enchere) {
            // Récupérer les lots associés à cette enchère
            $lots = $lotRepository->findBy(['idenchere' => $enchere]);

            // Stocker les lots associés à cette enchère dans le tableau associatif
            $lotsParEnchere[$enchere->getId()] = $lots;

            // Récupérer les produits associés à chaque lot dans cette enchère
            $produits = [];
            foreach ($lots as $lot) {
                $produits[$lot->getIdentifient()] = $produitRepository->findBy(['identifiant' => $lot]);
            }

            // Stocker les produits associés à chaque lot dans le tableau associatif
            $produitsParEnchere[$enchere->getId()] = $produits;
        }

        return $this->render('enchere/listEnchere.html.twig', [
            'encheres' => $encheres,
            'lotsParEnchere' => $lotsParEnchere,
            'produitsParEnchere' => $produitsParEnchere,
        ]);
    }


    /**
     * @Route("/augmenter-prix-actuel/{produit_id}", name="app_augmenter_prix_actuel", methods={"POST"})
     */
    public function augmenterPrixActuel(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $entityManager, int $produit_id): Response
    {
        $produit = $produitRepository->find($produit_id);

        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        // Récupérer le nouveau prix actuel depuis le formulaire
        $nouveauPrixActuel = $request->request->get('nouveau_prix_actuel');

        // Vérifier si le nouveau prix est supérieur à l'ancien prix
        if ($nouveauPrixActuel > $produit->getPrixActuel()) {
            // Mettre à jour le prix actuel
            $produit->setPrixActuel($nouveauPrixActuel);
            $entityManager->flush();
        } else {
            // Le nouveau prix est inférieur ou égal à l'ancien prix, affichez un message d'erreur ou faites quelque chose d'autre
            // Par exemple :
            $this->addFlash('error', 'Le nouveau prix doit être supérieur à l\'ancien prix.');
        }

        // Rediriger vers la page précédente ou une autre page appropriée
        return $this->redirectToRoute('app_listEnchere_index');
    }

    #[Route('/new', name: 'app_enchere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enchere = new Enchere2();
        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($enchere);
            $entityManager->flush();

            return $this->redirectToRoute('app_listEnchere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enchere/new.html.twig', [
            'enchere' => $enchere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enchere_show', methods: ['GET'])]
    public function show(Enchere2 $enchere): Response
    {
        return $this->render('enchere/show.html.twig', [
            'enchere' => $enchere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enchere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enchere2 $enchere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnchereType::class, $enchere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_enchere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enchere/edit.html.twig', [
            'enchere' => $enchere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enchere_delete', methods: ['POST'])]
    public function delete(Request $request, Enchere2 $enchere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $enchere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($enchere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enchere_index', [], Response::HTTP_SEE_OTHER);
    }
}
