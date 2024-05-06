<?php

namespace App\Controller;

use App\Entity\Dons;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonsController extends AbstractController
{
    #[Route('/back/dons', name: 'back_dons_index', methods: ['GET'])]
    public function index(): Response
    {
        $dons = $this->getDoctrine()->getRepository(Dons::class)->findAll();

        return $this->render('back_dons/display.html.twig', [
            'dons' => $dons,
        ]);
    }
}
