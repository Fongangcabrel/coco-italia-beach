<?php
require_once '../config.php';

// Ce fichier reçoit les webhooks Stripe (paiements confirmés)
// À configurer dans le dashboard Stripe : https://dashboard.stripe.com/webhooks

$stripe_lib = __DIR__ . '/../vendor/stripe/stripe-php/init.php';
if (!file_exists($stripe_lib)) {
    http_response_code(500);
    echo 'Stripe non installé';
    exit;
}
require_once $stripe_lib;

$payload   = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, STRIPE_WEBHOOK_SECRET);
} catch (\UnexpectedValueException $e) {
    http_response_code(400); exit;
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400); exit;
}

// Gérer l'événement
switch ($event->type) {
    case 'checkout.session.completed':
        $session  = $event->data->object;
        $metadata = $session->metadata;
        $email    = $session->customer_email;
        $amount   = $session->amount_total;

        // Log la vente (fichier simple, remplacer par DB en prod)
        $log_line = date('Y-m-d H:i:s') . " | " .
                    ($metadata->prenom ?? '') . " " . ($metadata->nom ?? '') . " | " .
                    $email . " | " .
                    ($metadata->ticket_type ?? '') . " x" . ($metadata->quantity ?? 1) . " | " .
                    ($amount / 100) . "€ | " . $session->id . "\n";
        file_put_contents(__DIR__ . '/../logs/ventes.log', $log_line, FILE_APPEND | LOCK_EX);

        // Envoyer email de confirmation à l'acheteur
        send_confirmation_email($email, $metadata, $amount, $session->id);

        // Notifier l'admin
        $admin_msg = "Nouvelle vente !\n\n" .
                     "Acheteur : " . ($metadata->prenom ?? '') . " " . ($metadata->nom ?? '') . "\n" .
                     "Email    : $email\n" .
                     "Billet   : " . ($metadata->ticket_type ?? '') . " x" . ($metadata->quantity ?? 1) . "\n" .
                     "Montant  : " . ($amount / 100) . "€\n" .
                     "Session  : " . $session->id;
        mail(ADMIN_EMAIL, "[Coco Italia Beach] Nouvelle vente !", $admin_msg);
        break;

    case 'payment_intent.payment_failed':
        // Paiement échoué — logger
        $intent = $event->data->object;
        $log_line = date('Y-m-d H:i:s') . " | ECHEC | " . ($intent->id ?? '') . "\n";
        file_put_contents(__DIR__ . '/../logs/echecs.log', $log_line, FILE_APPEND | LOCK_EX);
        break;
}

http_response_code(200);
echo json_encode(['received' => true]);

// ---- Fonction envoi email confirmation ----
function send_confirmation_email($email, $metadata, $amount, $session_id) {
    $prenom      = $metadata->prenom ?? '';
    $nom         = $metadata->nom ?? '';
    $ticket_type = $metadata->ticket_type ?? '';
    $quantity    = $metadata->quantity ?? 1;
    $label       = $ticket_type === 'full' ? 'Entrée Toute la Journée' : 'Entrée Journée';

    $subject = "🎟 Votre billet Coco Italia Beach — 25 juillet 2026";
    $body = "Bonjour $prenom $nom,\n\n";
    $body .= "Votre réservation est confirmée ! 🌴\n\n";
    $body .= "═══════════════════════════════\n";
    $body .= "  COCO ITALIA BEACH · PARMA\n";
    $body .= "  25 juillet 2026\n";
    $body .= "═══════════════════════════════\n\n";
    $body .= "📋 DÉTAILS DE VOTRE RÉSERVATION\n\n";
    $body .= "Billet      : $label\n";
    $body .= "Quantité    : $quantity billet(s)\n";
    $body .= "Total payé  : " . ($amount / 100) . "€\n";
    $body .= "Référence   : " . substr($session_id, 0, 20) . "\n\n";
    $body .= "📍 LIEU\n";
    $body .= "Strada Traversetolo 349A, Parma, Italie\n\n";
    $body .= "🕐 HORAIRES\n";
    $body .= "Ouverture : 10h00 — Fermeture : 23h00\n\n";
    $body .= "📱 VOTRE QR CODE\n";
    $body .= "Présentez cette référence à l'entrée : " . strtoupper(substr(md5($session_id), 0, 8)) . "\n\n";
    $body .= "À très bientôt sur la plage ! 🎉\n";
    $body .= "— L'équipe Coco Italia Beach";

    $headers = "From: billets@cocoitaliabeach.com\r\n";
    $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($email, $subject, $body, $headers);
}
