<?php

namespace App\Controller;

use App\Entity\Demand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends AbstractController
{
    
    #[Route('/back/demand', name: 'back_demand_index', methods: ['GET'])]
    public function index(): Response
    {
        $demands = $this->getDoctrine()->getRepository(Demand::class)->findAll();

        return $this->render('back/show.html.twig', [
            'demands' => $demands,
        ]);
    }
}
