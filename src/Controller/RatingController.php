<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rating;
use App\Form\RatingType;

class RatingController extends AbstractController
{
    #[Route('/rating', name: 'app_rating')]
    public function index(): Response
    {
        return $this->render('rating/index.html.twig', [
            'controller_name' => 'RatingController',
        ]);
    }
}