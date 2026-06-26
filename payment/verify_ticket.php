<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Méthode invalide']); exit;
}

if (empty($_SESSION['scan_auth'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non autorisé']); exit;
}

$code = strtoupper(trim($_POST['code'] ?? ''));
if (!$code) {
    echo json_encode(['status' => 'error', 'message' => 'Code vide']); exit;
}

$db_path = __DIR__ . '/../logs/tickets.db';
if (!file_exists($db_path)) {
    echo json_encode(['status' => 'invalid', 'message' => 'Aucun ticket enregistré']); exit;
}

$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare('SELECT * FROM tickets WHERE code = ?');
$stmt->execute([$code]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    echo json_encode(['status' => 'invalid', 'message' => 'Code inconnu — ticket introuvable']); exit;
}

if ($ticket['used_at']) {
    echo json_encode([
        'status'  => 'already_used',
        'message' => 'Ticket déjà utilisé',
        'used_at' => $ticket['used_at'],
        'data'    => $ticket,
    ]); exit;
}

// Marquer comme utilisé
$stmt = $db->prepare('UPDATE tickets SET used_at = ? WHERE code = ?');
$stmt->execute([date('Y-m-d H:i:s'), $code]);

echo json_encode([
    'status'  => 'valid',
    'message' => 'Ticket valide',
    'data'    => $ticket,
]);
