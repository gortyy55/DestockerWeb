<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Panier;
use App\Entity\User;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class FactureAdminController extends AbstractController
{
    #[Route('/facture/admin', name: 'app_facture_admin')]
    public function index(): Response
    {
        return $this->render('facture_admin/index.html.twig', [
            'controller_name' => 'FactureAdminController',
        ]);
    }


    #[Route('/displayAdmin_facture', name: 'display_facture')]
    public function displayFacture(FactureRepository $factureRepository): Response
    {
        $factures = $factureRepository->findFactureWithDetails();;
        
        return $this->render('facture_admin/display_facture.html.twig', [
            'factures' => $factures,
        ]);
    }

    #[Route('/facture/deleteAdmin/{id}', name: 'delete_facture_admin')]
    public function deleteFactureAdmin(int $id, EntityManagerInterface $entityManager): Response
    {
        $facture = $entityManager->getRepository(Facture::class)->find($id);

        // Check if the facture exists
        if (!$facture) {
            throw $this->createNotFoundException('Facture not found');
        }

        // Remove the facture from the database
        $entityManager->remove($facture);
        $entityManager->flush();

        // Redirect back to the admin facture list
        return $this->redirectToRoute('display_facture');
    }

    #[Route('/modify_facture/{id}', name: 'modify_facture',methods: ['GET', 'POST'])]
    public function modifyFacture(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('display_facture');
        }

        return $this->renderForm('facture_user/index.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    #[Route('/facture/search_ajax', name: 'search_ajax')]
    public function searchAction(Request $request, FactureRepository $factureRepository, EntityManagerInterface $entityManager)
    {
        $requestString = $request->query->get('q');
        $factures = $factureRepository->findFacturesByCountry($requestString);
    
        $result = [];
        if (!$factures) {
            $result['factures'] = ['error' => "There are no factures from this country."];
        } else {
            // Process factures and retrieve related data
            $result['factures'] = $this->processFactures($factures, $entityManager);
        }
    
        return new JsonResponse($result);
    }

    private function processFactures($factures, EntityManagerInterface $entityManager)
    {
        $processedFactures = [];
    
        foreach ($factures as $facture) {
            // Retrieve related data from associated entities (Panier and User)
            $idPanier = $facture->getIdPanier();
            $panier = $entityManager->getRepository(Panier::class)->find($idPanier);
            $idActeur = $panier->getIdActeur();
            $user = $entityManager->getRepository(User::class)->find($idActeur);
    
            // Build the array with necessary data
            $processedFactures[] = [
                'firstname' => $user->getFirstname(),
                'idPanier' => $facture->getIdPanier(),
                'prixtotal' => $panier->getPrixtotal(),
                'idFacture' => $facture->getIdFacture(),
                // Add more fields as needed
            ];
        }
    
        return $processedFactures;
    }
    
    
}
