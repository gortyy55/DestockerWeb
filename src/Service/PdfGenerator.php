<?php
// src/Service/PdfGenerator.php

// src/Service/PdfGenerator.php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Facture;
use Doctrine\ORM\EntityManagerInterface;

class PdfGenerator
{
    
    private $pdf;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->pdf = new Dompdf();
        $this->entityManager = $entityManager;
    }

    public function generatePdf(array $data)
    {
        // Extract data from the array
        $facture = $data['facture'] ?? null;
        $enchereData = $data['enchereData'] ?? [];
        $dateEnchere = $data['dateEnchere'] ?? null;
        $totalAmount = $data['totalAmount'] ?? null;

        // Check if necessary data is provided
        if (!$facture || !$dateEnchere) {
            throw new \InvalidArgumentException('Missing required data for PDF generation');
        }
        error_log('PDF generation started');
        // HTML content for the PDF
        $html = "<html><body>";
// Add your HTML content here using the provided data
$html .= "<h1>Facture Details</h1>";
// Add Date Enchere at the top right of the table
$html .= "<p style='text-align: right;'>Date Enchere: " . $dateEnchere->format('Y-m-d') . "</p>";

// Facture Details Table
$html .= "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
// Close Facture Details Table
$html .= "</table>";

// Enchere Data Table
$html .= "<table border='1' cellpadding='5' cellspacing='0' width='100%'>";
// Add Enchere data
$html .= "<tr><th width='50%'>Produit</th><th width='50%'>Prix Actuel</th></tr>";

foreach ($enchereData as $enchere) {
    $html .= "<tr><td width='50%'>" . $enchere['produit'] . "</td><td width='50%'>" . $enchere['prixactuel'] . "</td></tr>";
}
// Close Enchere Data Table
$html .= "</table>";
$html .= "<p style='text-align: right;'><strong>Total Amount: </strong>" . $totalAmount . "</p>";
// Close HTML body and document
$html .= "</body></html>";

        // Generate and add QR code
        $qrCodeUrl = "https://qrcode.tec-it.com/API/QRCode?data=https://maps.app.goo.gl/95NUsRZWU3TGo7GaA";
        $qrCodePath = 'C:/Users/ghofr/Desktop/pdf/qr_code.png';

        // Check if the image file exists
        if (file_exists($qrCodePath)) {
            // Delete the existing image file
            unlink($qrCodePath);
        }

        // Download the QR code image locally
        file_put_contents($qrCodePath, file_get_contents($qrCodeUrl));

        // Read the image file
        $imageData = file_get_contents($qrCodePath);

        // Convert image data to Base64 format
        $base64Image = 'data:image/png;base64,' . base64_encode($imageData);

        // Add the QR code image to the HTML content
        $html .= '<img src="' . htmlspecialchars($base64Image) . '" width="150" height="150">';

        // Close HTML body and document
        $html .= "</body></html>";

        // Load HTML content into Dompdf
        $this->pdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // Render PDF (generate bytes)
        $this->pdf->render();

        // Output PDF
        $output = $this->pdf->output();

        // Save PDF to file system (or send it as response, etc.)
        file_put_contents('C:/Users/ghofr/Desktop/pdf/'. $dateEnchere->format('Y-m-d').'.pdf', $output);

        // You can return $output if you want to handle it elsewhere (e.g., send as response)
       
    }
}
