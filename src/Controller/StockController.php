<?php

namespace App\Controller;
use App\Entity\Rating;
use App\Entity\Stock;
use App\Form\RatingType;
use App\Form\StockType;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\TwilioSmsService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Dompdf\Dompdf;


#[Route('/stock')]
class StockController extends AbstractController
{
    #[Route('/', name: 'app_stock_index', methods: ['GET'])]
    public function index(Request $request, StockRepository $stockRepository, PaginatorInterface $paginator): Response
    {
        
        $products = $stockRepository->findAllSortedByPrice();
        
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            3 // Set the number of items per page to 3
        );
    
        return $this->render('stock/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/pdf/generate', name: 'app_pdf_generate', methods: ['GET'])]
    public function generatePdf(StockRepository $stockRepository): Response
{
    
    $stocks = $stockRepository->findAll();

    // Créez une instance de Dompdf
    $dompdf = new Dompdf();

    // Générez le contenu HTML pour le PDF
    $htmlContent = $this->renderView('stock/pdf.html.twig', [
        'stocks' => $stocks,
    ]);

 
    $dompdf->loadHtml($htmlContent);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $pdfContent = $dompdf->output();

  
    $response = new Response($pdfContent);
    $response->headers->set('Content-Type', 'application/pdf');


    return $response;
}
    #[Route('/search/ajax', name: 'stock_search_ajax', methods: ['GET'])]
    public function searchAjax(Request $request, StockRepository $stockRepository): Response
    {
        $query = $request->query->get('query');
        $results = $stockRepository->searchByName($query);

        return $this->render('stock/_search_results.html.twig', [
            'results' => $results,
        ]);
    }
    
  

    #[Route('/new', name: 'app_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stock);
            $entityManager->flush();
    
            // Get Twilio credentials from parameters
            $accountSid = $parameterBag->get('TWILIO_ACCOUNT_SID');
            $authToken = $parameterBag->get('TWILIO_AUTH_TOKEN');
            $twilioPhoneNumber = $parameterBag->get('TWILIO_PHONE_NUMBER');
    
            // Instantiate TwilioSmsService
            $twilioSmsService = new TwilioSmsService($accountSid, $authToken, $twilioPhoneNumber);
    
            // Send SMS notification
            $message = "A new product has been added: {$stock->getProduitname()}";
            $twilioSmsService->sendSms('+21622097795', $message);
    
            return $this->redirectToRoute('app_stock_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('stock/new.html.twig', [
            'stock' => $stock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_show', methods: ['GET'])]
    public function show(Stock $stock): Response
    {
        return $this->render('stock/show.html.twig', [
            'stock' => $stock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stock $stock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock/edit.html.twig', [
            'stock' => $stock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_delete', methods: ['POST'])]
    public function delete(Request $request, Stock $stock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/search', name: 'app_stock_search', methods: ['GET'])]
/*public function search(Request $request, StockRepository $stockRepository): JsonResponse
{
    $query = $request->query->get('query');
    $stocks = $stockRepository->search($query); // Implement this method in StockRepository

    // Prepare data for JSON response
    $response = [];
    foreach ($stocks as $stock) {
        $response[] = [
            'id' => $stock->getId(),
            'productName' => $stock->getProductName(), // Adjust field name as per your entity
            // Add other fields you need
        ];
    }

    return new JsonResponse($response);
}*/

#[Route('/stock/{id}/rate', name: 'rate_app', methods: ['GET', 'POST'])]
public function rate(Request $request, Stock $stock, EntityManagerInterface $entityManager): Response
{
    $rating = new Rating();
    $rating->setStock($stock);
    $form = $this->createForm(RatingType::class, $rating);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($rating);
        $entityManager->flush();

        $stock->updateAverageRating();
        $entityManager->flush();

        $this->addFlash('success', 'Rating submitted successfully.');

        return $this->redirectToRoute('app_stock_index');
    }

    return $this->render('rating/rate.html.twig', [
        'form' => $form->createView(),
        'stock' => $stock,
    ]);
}

}
