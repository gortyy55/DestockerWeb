<?php

namespace App\Controller;


use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $query = $request->query->get('q');

        $stocks = $entityManager->getRepository(Stock::class)->searchByName($query);

        $results = [];
        foreach ($stocks as $stock) {
            $results[] = [
                'id' => $stock->getId(),
                'productName' => $stock->getProduitname(),
                // Add other properties you want to include
            ];
        }

        return new JsonResponse($results);
    }
}
