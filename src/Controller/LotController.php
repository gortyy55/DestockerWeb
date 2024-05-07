<?php

namespace App\Controller;

use App\Form\EnchereType;
use App\Repository\ProduitRepository;

use App\Entity\Enchere2;
use App\Entity\produit;
use App\Entity\Lot;
use App\Form\LotType;
use App\Repository\LotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lot")
 */
class LotController extends AbstractController
{
    /**
     * @Route("/", name="app_lot_index", methods={"GET"})
     */

    public function index(LotRepository $lotRepository, ProduitRepository $produitRepository): Response
    {
        $lots = $lotRepository->findAll();

        // Créer un tableau associatif pour stocker les produits associés à chaque lot
        $produitsParLot = [];

        // Parcourir chaque lot pour récupérer les produits associés
        foreach ($lots as $lot) {
            $produits = $produitRepository->findBy(['identifiant' => $lot]);
            $produitsParLot[$lot->getIdentifient()] = $produits;
        }

        return $this->render('lot/index.html.twig', [
            'lots' => $lots,
            'produitsParLot' => $produitsParLot,
        ]);
    }




    /**
     * @Route("/new", name="app_lot_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lot = new Lot();
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Enregistrez d'abord le lot
            $entityManager->persist($lot);
            $entityManager->flush();

            // Récupérez les données du formulaire pour les produits
            $produitsData = $form->get('produits')->getData();

            // Créez et associez chaque produit au lot
            foreach ($produitsData as $produitData) {
                $produit = new Produit();
                // Peut-être ajustez-vous cela en fonction de votre formulaire et de l'entité Produit
                $produit->setNom($produitData['nom']);
                $produit->setPrix($produitData['prix']);
                $produit->setPrixActuel($produitData['prixActuel']);
                $produit->setLot($lot);
                $entityManager->persist($produit);
            }

            // Enregistrez les produits associés au lot
            $entityManager->flush();

            return $this->redirectToRoute('app_lot_index');
        }

        return $this->render('lot/new.html.twig', [
            'lot' => $lot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_lot_show", methods={"GET"})
     */
    public function show(Lot $lot, ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits associés à ce lot
        $produits = $produitRepository->findBy(['identifiant' => $lot]);

        return $this->render('lot/show.html.twig', [
            'lot' => $lot,
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_lot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lot $lot, EntityManagerInterface $entityManager): Response

    {
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez d'abord les modifications apportées au lot
            $entityManager->flush();


            // Redirigez vers la liste des lots
            return $this->redirectToRoute('app_lot_index');
        }

        return $this->render('lot/edit.html.twig', [
            'lots' => $lot,
            'form' => $form,
        ]);
    }





    /**
     * @Route("/{id}", name="app_lot_delete", methods={"POST"})
     */
    public function delete(Request $request, Lot $lot, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lot->getIdentifient(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lot_index');
    }
}
