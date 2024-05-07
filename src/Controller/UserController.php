<?php

namespace App\Controller;

use App\Repository\EnchereRepository;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/userEnchere', name: 'app_user')]
    public function displaybids(EnchereRepository $enchereRepository, PanierRepository $panierRepository): Response
    {
        // Fetch specific attributes from the repository
        $enchereData = $enchereRepository->findAllSpecificAttributes(); // Implement this method in EnchereRepository
        $cartItems = $panierRepository->getPanierWithProduit();
        $numberOfItems = count($cartItems);
        // Render the Twig template and pass the data
        return $this->render('user/afficheEnchere.html.twig', [
            'enchereData' => $enchereData,
            'numberOfItems' => $numberOfItems, // Passing fetched data to the template
        ]);
    }
}
