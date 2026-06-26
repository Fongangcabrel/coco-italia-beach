<?php
require_once '../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/lib/generate_ticket.php';

$fake_data = [
    'session_id'  => 'cs_test_preview',
    'prenom'      => 'Jean',
    'nom'         => 'Dupont',
    'email'       => 'jean.dupont@example.com',
    'telephone'   => '+33 6 00 00 00 00',
    'ticket_type' => $_GET['type'] ?? 'full',
    'quantity'    => 2,
    'amount'      => 3000,
    'code'        => 'A3F2-B891',
];

$pdf = generate_ticket_pdf($fake_data);

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="test-billet.pdf"');
header('Content-Length: ' . strlen($pdf));
echo $pdf;
