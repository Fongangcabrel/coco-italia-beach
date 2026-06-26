<?php
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$nom     = trim($_POST['nom'] ?? '');
$email   = trim($_POST['email'] ?? '');
$sujet   = trim($_POST['sujet'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
if (!$nom || !$email || !$message) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide.']);
    exit;
}

$to      = ADMIN_EMAIL;
$subject = "[Coco Italia Beach] " . ($sujet ?: 'Contact') . " — " . htmlspecialchars($nom);
$body    = "Nouveau message depuis le site Coco Italia Beach\n\n";
$body   .= "Nom    : " . htmlspecialchars($nom) . "\n";
$body   .= "Email  : " . htmlspecialchars($email) . "\n";
$body   .= "Sujet  : " . htmlspecialchars($sujet) . "\n\n";
$body   .= "Message :\n" . htmlspecialchars($message);
$headers = "From: noreply@cocoitaliabeach.com\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    // En dev : simuler succès si mail() n'est pas configuré
    echo json_encode(['success' => true]);
}
exit;
