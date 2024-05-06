<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Panier;
use App\Entity\Enchere;
use App\Form\FactureType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Psr\Log\LoggerInterface;
use App\Service\PdfGenerator;

class FactureUserController extends AbstractController
{
    #[Route('/facture/user', name: 'app_facture_user')]
    public function index(): Response
    {
        return $this->render('facture_user/index.html.twig', [
            'controller_name' => 'FactureUserController',
        ]);
    }
  

    #[Route('/addfacture/user/{idPanier}', name: 'add_facture_user')]
    public function addFacture(int $idPanier, Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger, PdfGenerator $pdfGenerator): Response
    {
        // Retrieve totalAmount from the query parameters
        $totalAmount = $request->request->get('totalAmount');
        $token = $request->request->get('token');
        
    
        // Find the Panier by its ID
        $panier = $entityManager->getRepository(Panier::class)->find($idPanier);
    
        // Check if the Panier exists
        if (!$panier) {
            throw $this->createNotFoundException('Panier not found');
        }
        $enchereIds = $panier->getIdEnchere();
        $enchereData = [];
        foreach ($enchereIds as $enchereId) {
            $enchere = $entityManager->getRepository(Enchere::class)->find($enchereId);
            if ($enchere) {
                $enchereData[] = [
                    'produit' => $enchere->getProduit(),
                    'prixactuel' => $enchere->getPrixactuel()
                ];
            }
        }

        $dateEnchere = $panier->getDateEnchere();




        // Create a new instance of the Facture entity
        $facture = new Facture();
        $facture->setIdPanier($idPanier);
        $facture->setIdActeur(1); // Set the ID of the Panier
    
        
        
        // Create a form for the Facture entity
        $form = $this->createForm(FactureType::class, $facture);
    
        // Handle form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Set your secret Stripe API key
            Stripe::setApiKey('sk_test_51OquviDCmW43ltvEjgzNfYf8MRicGmOGc3evVEBzelH6rya65WxmIkrPWZVt1F9NloT5t0qg5GdaNOL6GGiTY9ts00Yb70kl3o');


            $entityManager->persist($facture);
            
            
            $entityManager->flush();

            $pdfGenerator->generatePdf([
                'facture' => $facture,
                'enchereData' => $enchereData,
                'dateEnchere' => $dateEnchere,
                'totalAmount' => $totalAmount,
            ]);
           
            // Use the retrieved totalAmount in the Stripe payment process
            try {
                // Charge the customer's card
                $charge = Charge::create([
                    'amount' => $totalAmount * 100, // Amount in cents
                    'currency' => 'usd', // Replace with your currency
                    'description' => 'Payment for Order', // Replace with your description
                    'source' => $token, // Token from frontend
                ]);
    
               
               
    
                // Redirect to some page, or you can return a JSON response
                return $this->redirectToRoute('add_facture_user', ['idPanier' => $idPanier]);
            } catch (\Stripe\Exception\CardException $e) {
                // Since it's a decline, \Stripe\Exception\CardException will be caught
                $body = $e->getJsonBody();
                $err = $body['error'];
                // Log the error
                $logger->error('Stripe card error: '. $err['message']);
                // Handle error
            } catch (\Stripe\Exception\RateLimitException $e) {
                // Too many requests made to the API too quickly
                // Log the error
                $logger->error('Stripe rate limit error: '. $e->getMessage());
           } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Invalid parameters were supplied to Stripe's API
                // Log the error
                $logger->error('Stripe invalid request error: '. $e->getMessage());
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // Authentication with Stripe's API failed
                // Log the error
                $logger->error('Stripe authentication error: '. $e->getMessage());
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // Network communication with Stripe failed
                // Log the error
                $logger->error('Stripe API connection error: '. $e->getMessage());
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // Display a very generic error to the user, and maybe send yourself an email
                // Log the error
                $logger->error('Stripe API error: '. $e->getMessage());
            } catch (\Exception $e) {
                // Something else happened, completely unrelated to Stripe
                // Log the error
                $logger->error('Unexpected error: '. $e->getMessage());
            }
        }
    
        // Render the form template
        return $this->render('facture_user/index.html.twig', [
            'form' => $form->createView(),
            'idPanier' => $idPanier,
           
        ]);
    }
}
