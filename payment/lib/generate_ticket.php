<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Génère un code court unique de 12 caractères (ex: A3F2-B891-C4D5)
 */
function generate_short_code(string $session_id): string
{
    $raw = strtoupper(substr(hash_hmac('sha256', $session_id, TICKET_SECRET), 0, 8));
    return substr($raw, 0, 4) . '-' . substr($raw, 4, 4);
}

/**
 * Génère le PDF du ticket et retourne le contenu binaire.
 */
function generate_ticket_pdf(array $data): string
{
    $prenom      = $data['prenom'];
    $nom         = $data['nom'];
    $email       = $data['email'];
    $ticket_type = $data['ticket_type'];
    $quantity    = (int)$data['quantity'];
    $amount      = (int)$data['amount'];
    $session_id  = $data['session_id'];
    $code        = $data['code'] ?? generate_short_code($session_id);

    $label     = $ticket_type === 'full' ? 'Entrée Toute la Journée' : 'Entrée Journée';
    $prix_unit = $ticket_type === 'full' ? (PRICE_FULL_DAY / 100) : (PRICE_JOURNEE / 100);

    // Logo en base64
    $logo_path = __DIR__ . '/../../assets/img/beach-logo.jpeg';
    $logo_b64  = file_exists($logo_path) ? base64_encode(file_get_contents($logo_path)) : '';

    $html = '<!DOCTYPE html><html><head><meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; }
        body { font-family: DejaVu Sans, sans-serif; font-size:11px; color:#3E2311; background:#fff; margin:0; padding:24px 28px; }
        table { border-collapse:collapse; }
        .header-table { width:100%; background-color:#3E2311; border-radius:8px; }
        .header-table td { padding:14px 20px; color:#fff; vertical-align:middle; text-align:center; }
        .logo-cell { background-color:#fff; border-radius:6px; padding:6px 10px; display:inline-block; }
        .site-title { font-size:20px; font-weight:bold; letter-spacing:2px; margin-top:8px; }
        .site-sub   { font-size:10px; color:#F0D5B0; margin-top:3px; }
        .main-table { width:100%; margin-top:16px; }
        .main-table td { vertical-align:top; padding:0; }
        .left-col  { width:62%; padding-right:16px; }
        .right-col { width:38%; }
        .badge { background-color:#FFF4E6; border:2px solid #F47C20; border-radius:8px; padding:10px 14px; margin-bottom:12px; }
        .badge-label { font-size:9px; color:#8B4513; text-transform:uppercase; letter-spacing:1px; }
        .badge-value { font-size:14px; font-weight:bold; color:#3E2311; margin-top:2px; }
        .info-table { width:100%; }
        .info-table td { padding:4px 0; font-size:10px; }
        .info-label { color:#999; width:42%; }
        .info-value { font-weight:bold; color:#3E2311; }
        .divider { border:none; border-top:1px dashed #F0D5B0; margin:8px 0; }
        .code-box { background-color:#FFF4E6; border:3px solid #F47C20; border-radius:10px; padding:16px 12px; text-align:center; }
        .code-title { font-size:9px; color:#8B4513; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
        .code-value { font-size:24px; font-weight:bold; color:#3E2311; letter-spacing:4px; font-family: DejaVu Sans Mono, monospace; }
        .code-hint  { font-size:8px; color:#aaa; margin-top:8px; line-height:1.5; }
        .footer { margin-top:14px; padding:10px 16px; background-color:#FFF4E6; border-radius:8px; font-size:9px; color:#999; text-align:center; }
    </style></head><body>

    <table class="header-table"><tr>
        <td>
            ' . ($logo_b64 ? '<div class="logo-cell"><img src="data:image/jpeg;base64,' . $logo_b64 . '" style="height:70px;width:auto;display:block;"></div>' : '') . '
            <div class="site-title">COCO ITALIA BEACH</div>
            <div class="site-sub">Samedi 25 juillet 2026 &nbsp;&middot;&nbsp; Strada Traversetolo 349A, Parma</div>
        </td>
    </tr></table>

    <table class="main-table"><tr>
        <td class="left-col">
            <div class="badge">
                <div class="badge-label">Type de billet</div>
                <div class="badge-value">' . htmlspecialchars($label) . '</div>
            </div>
            <table class="info-table">
                <tr><td class="info-label">Nom</td><td class="info-value">' . htmlspecialchars("$prenom $nom") . '</td></tr>
                <tr><td class="info-label">Email</td><td class="info-value">' . htmlspecialchars($email) . '</td></tr>
                <tr><td class="info-label">Quantite</td><td class="info-value">' . $quantity . ' billet(s)</td></tr>
                <tr><td class="info-label">Prix unitaire</td><td class="info-value">' . $prix_unit . ' EUR</td></tr>
                <tr><td class="info-label">Total paye</td><td class="info-value">' . ($amount / 100) . ' EUR</td></tr>
                <tr><td colspan="2"><hr class="divider"></td></tr>
                <tr><td class="info-label">Lieu</td><td class="info-value">Strada Traversetolo 349A, Parma</td></tr>
                <tr><td class="info-label">Horaires</td><td class="info-value">10h00 - 23h00</td></tr>
            </table>
        </td>
        <td class="right-col">
            <div class="code-box">
                <div class="code-title">Code d\'entree</div>
                <div class="code-value">' . $code . '</div>
                <div class="code-hint">Presentez ce code a l\'entree.<br>Imprime ou sur smartphone.</div>
            </div>
        </td>
    </tr></table>

    <div class="footer">Merci pour votre reservation &nbsp;&middot;&nbsp; Contact : ' . ADMIN_EMAIL . '</div>
    </body></html>';

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', false);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A5', 'landscape');
    $dompdf->render();

    return $dompdf->output();
}
