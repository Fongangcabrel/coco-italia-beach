<?php
require_once '../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/lib/generate_ticket.php';

$order = $_SESSION['download_ticket'] ?? null;

if (!$order || empty($order['session_id'])) {
    http_response_code(403);
    echo 'Accès refusé.';
    exit;
}

$pdf_content = generate_ticket_pdf($order);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="billet-coco-italia-beach.pdf"');
header('Content-Length: ' . strlen($pdf_content));
header('Cache-Control: no-cache');
echo $pdf_content;
exit;
