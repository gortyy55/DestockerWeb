<?php

namespace App\Controller;

use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartAdminController extends AbstractController
{
    // #[Route('/displaycart/admin', name: 'display_cart_admin')]
    // public function displayAdmin(PanierRepository $panierRepository): Response
    // {
    //     $adminPanier = $panierRepository->getAdminPanier();
    //     return $this->render('cart_admin/cartAdmin.html.twig', [
    //         'adminPanier' => $adminPanier,
    //     ]);
    // }

    #[Route('/displaycart/admin', name: 'display_cart_admin')]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('cart_admin/cartAdmin.html.twig', [
            'adminPanier' => $panierRepository->findAll(),
        ]);
    }

    #[Route('/deletecart/admin/{id}', name: 'delete_cart_admin')]
    public function deletePanier(PanierRepository $panierRepository, EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        // Find the Panier entity by id
        $panier = $panierRepository->find($id);

        // If the Panier entity is not found, redirect back or handle appropriately
        if (!$panier) {
            // Redirect back or handle appropriately
            // For example, redirecting back to the previous page
            return $this->redirectToRoute('display_cart_admin');
        }

        // Remove the Panier entity
        $entityManager->remove($panier);
        $entityManager->flush();

        // Redirect to a success page or handle appropriately
        return $this->redirectToRoute('display_cart_admin');
    }

   

}
