<?php
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Méthode non autorisée']); exit;
}

// Récupérer les données
$ticket_type  = $_POST['ticket_type'] ?? 'journee';
$prenom       = trim($_POST['prenom'] ?? '');
$nom          = trim($_POST['nom'] ?? '');
$email        = trim($_POST['email'] ?? '');
$telephone    = trim($_POST['telephone'] ?? '');
$quantity     = max(1, min(10, intval($_POST['quantity'] ?? 1)));

// Validation
if (!$prenom || !$nom || !$email) {
    echo json_encode(['error' => 'Veuillez remplir tous les champs obligatoires.']); exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Email invalide.']); exit;
}

// Définir le prix
$prices = [
    'journee' => ['amount' => PRICE_JOURNEE, 'label' => 'Entrée Journée — Coco Italia Beach'],
    'full'    => ['amount' => PRICE_FULL_DAY, 'label' => 'Entrée Toute la Journée — Coco Italia Beach'],
];
if (!isset($prices[$ticket_type])) {
    echo json_encode(['error' => 'Type de billet invalide.']); exit;
}

$price_data = $prices[$ticket_type];

// Sauvegarder les infos en session pour la page de succès
$_SESSION['pending_order'] = [
    'prenom'      => $prenom,
    'nom'         => $nom,
    'email'       => $email,
    'telephone'   => $telephone,
    'ticket_type' => $ticket_type,
    'quantity'    => $quantity,
    'amount'      => $price_data['amount'] * $quantity,
];

// Charger la lib Stripe
$stripe_lib = __DIR__ . '/../vendor/stripe/stripe-php/init.php';
if (!file_exists($stripe_lib)) {
    // Stripe non installé → redirection vers page d'info
    echo json_encode(['error' => 'Stripe non configuré. Veuillez installer via Composer (voir INSTALLATION.md).']); exit;
}
require_once $stripe_lib;

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'customer_email'       => $email,
        'line_items'           => [[
            'price_data' => [
                'currency'     => 'eur',
                'unit_amount'  => $price_data['amount'],
                'product_data' => [
                    'name'        => $price_data['label'],
                    'description' => 'Événement du 25 juillet 2026 — Strada Traversetolo 349A, Parma',
                    'images'      => [],
                ],
            ],
            'quantity' => $quantity,
        ]],
        'mode'                 => 'payment',
        'success_url'          => SITE_URL . '/payment/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'           => SITE_URL . '/pages/billetterie.php?cancelled=1',
        'metadata'             => [
            'prenom'      => $prenom,
            'nom'         => $nom,
            'telephone'   => $telephone,
            'ticket_type' => $ticket_type,
            'quantity'    => $quantity,
        ],
        'locale' => 'fr',
        'payment_intent_data' => [
            'description' => "Coco Italia Beach — $prenom $nom — $ticket_type x$quantity",
        ],
    ]);

    echo json_encode(['url' => $session->url]);

} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['error' => 'Erreur Stripe : ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
exit;
