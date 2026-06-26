<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/generate_ticket.php';
require_once __DIR__ . '/store_ticket.php';

/**
 * Traite un paiement confirmé : stocke le ticket, génère le PDF, envoie l'email.
 * Retourne le code court du ticket, ou null si déjà traité (idempotent).
 */
function process_confirmed_payment(array $ticket_data): ?string
{
    // INSERT OR IGNORE garantit l'idempotence — pas de doublon si appelé deux fois
    $code = store_ticket($ticket_data);
    $ticket_data['code'] = $code;

    // Log vente
    $log_line = date('Y-m-d H:i:s') . " | " .
                ($ticket_data['prenom'] ?? '') . " " . ($ticket_data['nom'] ?? '') . " | " .
                ($ticket_data['email'] ?? '') . " | " .
                ($ticket_data['ticket_type'] ?? '') . " x" . ($ticket_data['quantity'] ?? 1) . " | " .
                (($ticket_data['amount'] ?? 0) / 100) . "EUR | " . ($ticket_data['session_id'] ?? '') . "\n";
    $log_dir = __DIR__ . '/../../logs';
    if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
    file_put_contents($log_dir . '/ventes.log', $log_line, FILE_APPEND | LOCK_EX);

    // Générer PDF et envoyer email
    $pdf_content = generate_ticket_pdf($ticket_data);
    send_ticket_email($ticket_data['email'], $ticket_data, $pdf_content);

    return $code;
}

function send_ticket_email(string $email, array $data, string $pdf_content): void
{
    $prenom      = $data['prenom'];
    $nom         = $data['nom'];
    $ticket_type = $data['ticket_type'];
    $quantity    = $data['quantity'];
    $amount      = $data['amount'];
    $code        = $data['code'] ?? '';
    $label       = $ticket_type === 'full' ? 'Entrée Toute la Journée' : 'Entrée Journée';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = MAIL_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USERNAME;
    $mail->Password   = MAIL_PASSWORD;
    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = MAIL_PORT;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress($email, "$prenom $nom");
    $mail->addReplyTo(ADMIN_EMAIL);

    $mail->Subject = "Votre billet Coco Italia Beach - 25 juillet 2026";
    $mail->Body    = "Bonjour $prenom $nom,\n\n"
                   . "Votre reservation est confirmee !\n\n"
                   . "Billet   : $label\n"
                   . "Quantite : $quantity billet(s)\n"
                   . "Total    : " . ($amount / 100) . "EUR\n"
                   . "Code     : $code\n\n"
                   . "Strada Traversetolo 349A, Parma\n"
                   . "Samedi 25 juillet 2026 - 10h00 a 23h00\n\n"
                   . "Votre billet PDF est en piece jointe. Presentez le code a l'entree.\n\n"
                   . "A tres bientot sur la plage !\n"
                   . "L'equipe Coco Italia Beach";

    $mail->addStringAttachment($pdf_content, 'billet-coco-italia-beach.pdf', \PHPMailer\PHPMailer\PHPMailer::ENCODING_BASE64, 'application/pdf');
    $mail->send();
}
