<?php

namespace App\Controller;
use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics')]
class StatisticsController extends AbstractController
{
    #[Route('/category_usage', name: 'category_usage_statistics')]
    public function categoryUsage(EntityManagerInterface $entityManager): Response
    {
        // Fetch data from the database
        $repository = $entityManager->getRepository(Stock::class);
        $categoryCounts = $repository->createQueryBuilder('s')
            ->select('c.category_name AS category, COUNT(s.id) AS count')
            ->leftJoin('s.id_cat', 'c')
            ->groupBy('c.category_name')
            ->getQuery()
            ->getResult();

        // Format data for Chart.js
        $labels = [];
        $data = [];
        foreach ($categoryCounts as $categoryCount) {
            $labels[] = $categoryCount['category'];
            $data[] = $categoryCount['count'];
        }

        // Render the template with the data
        return $this->render('statistics/category_usage.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }
}
