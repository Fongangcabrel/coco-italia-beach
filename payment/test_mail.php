<?php
require_once '../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/lib/process_ticket.php';

$result  = null;
$error   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = trim($_POST['email'] ?? '');
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalide.';
    } else {
        $fake_data = [
            'session_id'  => 'cs_test_' . md5(uniqid()),
            'prenom'      => 'Jean',
            'nom'         => 'Dupont',
            'email'       => $to,
            'telephone'   => '+33 6 00 00 00 00',
            'ticket_type' => 'full',
            'quantity'    => 2,
            'amount'      => 3000,
        ];

        try {
            $code = process_confirmed_payment($fake_data);
            $result = "Email envoyé à $to — Code : <strong>$code</strong>";
        } catch (\Exception $e) {
            $error = 'Erreur : ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test envoi email</title>
    <style>
        body { font-family: sans-serif; max-width: 500px; margin: 60px auto; padding: 0 20px; }
        h1   { font-size: 22px; margin-bottom: 24px; }
        input[type=email] { width: 100%; padding: 10px; font-size: 15px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { margin-top: 12px; padding: 10px 24px; background: #3E2311; color: #fff; border: none; border-radius: 6px; font-size: 15px; cursor: pointer; }
        .success { background: #D1FAE5; border: 1px solid #6EE7B7; color: #065F46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .error   { background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .config  { background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 6px; padding: 14px; font-size: 13px; margin-top: 32px; }
        .config p { margin: 4px 0; }
    </style>
</head>
<body>
    <h1>🧪 Test envoi email + PDF</h1>

    <?php if ($result): ?>
        <div class="success">✅ <?= htmlspecialchars($result) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="error">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Adresse email de test</label><br><br>
        <input type="email" name="email" id="email" placeholder="votre@email.com" required
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <button type="submit">Envoyer le test</button>
    </form>

    <div class="config">
        <strong>Configuration SMTP actuelle</strong>
        <p>Host : <?= htmlspecialchars(MAIL_HOST) ?></p>
        <p>Port : <?= MAIL_PORT ?></p>
        <p>From : <?= htmlspecialchars(MAIL_FROM) ?></p>
    </div>
</body>
</html>
