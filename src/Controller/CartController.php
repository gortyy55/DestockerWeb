<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\EnchereRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/addCart', name: 'add_cart')]
public function addEnchereToPanier(Request $request, EntityManagerInterface $entityManager): Response
{
    $requestData = json_decode($request->getContent(), true);

    $ids = $requestData['ids'] ?? [];
    $totalPrice = $requestData['totalPrice'] ?? 0; // Default to 0 if not provided

    // Ensure $ids is an array
    if (!is_array($ids)) {
        // Handle cases where $ids is not an array (e.g., a single ID passed as a string)
        $ids = [$ids];
    }

    // Create a new Panier entry
    $panier = new Panier();

    // Set the IDs of the Enchere(s)
    $panier->setIdEnchere($ids);

    $panier->setIdActeur(1); // Manually set the user ID to 1

    // Set the total price
    $panier->setPrixtotal($totalPrice);

    // Set the date of the enchere
    $panier->setDateEnchere(new \DateTime());

    // Persist the Panier entity
    $entityManager->persist($panier);

    // Flush all changes to the database
    $entityManager->flush();

    // Return the ID of the newly created Panier as JSON response
    return new JsonResponse(['id_panier' => $panier->getIdPanier()], JsonResponse::HTTP_OK);
}






#[Route('/displayCart', name: 'display_cart')]
public function displayCart(Request $request, PanierRepository $panierRepository, EnchereRepository $enchereRepository): Response
{
    $id_panier = $request->query->get('id_panier');

    // Check if id_panier is provided
    if (!$id_panier) {
        return new Response('No id_panier provided', Response::HTTP_BAD_REQUEST);
    }

    // Retrieve Panier entity based on id_panier
    $panier = $panierRepository->find($id_panier);

    // Check if Panier entity is found
    if (!$panier) {
        return new Response('No Panier found for id_panier: ' . $id_panier, Response::HTTP_NOT_FOUND);
    }

    $enchereDetails = [];
    $enchereIds = $panier->getIdEnchere();
    
    // Check if $enchereIds is null or empty
    if ($enchereIds === null || $enchereIds === '') {
        // Handle the case where $enchereIds is null or empty
        echo "<script>console.error('Enchere IDs are null or empty for Panier ID: " . $id_panier . "');</script>";
        // You might want to return an error response or handle it according to your application's logic
        return new Response('Enchere IDs are null or empty for Panier ID: ' . $id_panier, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    
    // Check if $enchereIds is a non-empty string
    if (is_string($enchereIds)) {
        // Attempt to decode $enchereIds as JSON
        $decodedIds = json_decode($enchereIds, true);
    
        // Check if decoding was successful
        if ($decodedIds === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle the case where decoding failed
            echo "<script>console.error('Failed to decode Enchere IDs for Panier ID: " . $id_panier . "');</script>";
            // You might want to return an error response or handle it according to your application's logic
            return new Response('Failed to decode Enchere IDs for Panier ID: ' . $id_panier, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    
        // Use the decoded IDs
        $enchereIds = $decodedIds;
    }
    
    // Loop through each Enchere ID
    foreach ($enchereIds as $enchereId) {
        // Remove unwanted characters (e.g., "[", "]") from the ID
        $enchereId = trim($enchereId, '["]');
    
        // Retrieve Enchere entity based on the ID
        $enchere = $enchereRepository->find($enchereId);
        
        // Check if Enchere entity is found
        if ($enchere) {
            // Add Enchere details to enchereDetails array
            $enchereDetails[] = [
                'produit' => $enchere->getProduit(),
                'enchere' => $enchere->getId(),
                'prix' => $enchere->getPrixActuel()
            ];
        } else {
            // If Enchere entity is not found, log an error
            echo "<script>console.error('Enchere not found for ID: " . $enchereId . "');</script>";
        }
    }


    // Check if enchereDetails array is populated correctly
    if (empty($enchereDetails)) {
        echo "<script>console.error('No Enchere details found for Panier ID: " . $id_panier . "');</script>";
    }

    // Calculate total amount
    $totalAmount = array_sum(array_column($enchereDetails, 'prix'));

    // Render the view with the data
    return $this->render('cart/cartUser.html.twig', [
        'cartItems' => $enchereDetails,
        'totalAmount' => $totalAmount,
    ]);
}



}