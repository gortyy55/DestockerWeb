<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StockRepository;

class StockBackController extends AbstractController
{
    #[Route('/stock/back', name: 'app_stock_back', methods: ['GET'])]
    public function index(StockRepository $stockRepository): Response
    {
        return $this->render('stock_back/index.html.twig', [
            'stocks' => $stockRepository->findAll(),
        ]);
    }
}
