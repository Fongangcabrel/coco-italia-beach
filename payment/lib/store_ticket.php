<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/generate_ticket.php';

/**
 * Stocke un ticket dans SQLite après paiement confirmé.
 * Retourne le code court généré.
 */
function store_ticket(array $data): string
{
    $db_path = __DIR__ . '/../../logs/tickets.db';
    $db_dir  = dirname($db_path);
    if (!is_dir($db_dir)) mkdir($db_dir, 0755, true);

    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS tickets (
        code        TEXT PRIMARY KEY,
        session_id  TEXT NOT NULL,
        prenom      TEXT,
        nom         TEXT,
        email       TEXT,
        telephone   TEXT,
        ticket_type TEXT,
        quantity    INTEGER,
        amount      INTEGER,
        created_at  TEXT NOT NULL,
        used_at     TEXT
    )");

    $code = generate_short_code($data['session_id']);

    $stmt = $db->prepare("INSERT OR IGNORE INTO tickets
        (code, session_id, prenom, nom, email, telephone, ticket_type, quantity, amount, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $code,
        $data['session_id'],
        $data['prenom']      ?? '',
        $data['nom']         ?? '',
        $data['email']       ?? '',
        $data['telephone']   ?? '',
        $data['ticket_type'] ?? 'journee',
        (int)($data['quantity'] ?? 1),
        (int)($data['amount']   ?? 0),
        date('Y-m-d H:i:s'),
    ]);

    return $code;
}
