<?php
// Détection automatique du chemin de base — marche en local ET en prod
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script   = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$root_dir = str_replace('\\', '/', realpath(__DIR__));
$doc_root = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? __DIR__));
$rel      = ltrim(str_replace($doc_root, '', $root_dir), '/');
define('SITE_URL', rtrim($protocol . '://' . $host . ($rel ? '/' . $rel : ''), '/'));

// Profondeur relative (pour CSS/JS depuis sous-dossiers)
$current = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME'] ?? __FILE__));
$depth   = substr_count(str_replace($root_dir, '', $current), '/') - 1;
define('ROOT_REL', str_repeat('../', max(0, $depth)));

// Stripe — remplacer par vos vraies clés
define('STRIPE_PUBLIC_KEY',    'pk_test_VOTRE_CLE_PUBLIQUE_STRIPE');
define('STRIPE_SECRET_KEY',    'sk_test_VOTRE_CLE_SECRETE_STRIPE');
define('STRIPE_WEBHOOK_SECRET','whsec_VOTRE_WEBHOOK_SECRET');

define('ADMIN_EMAIL',    'c.bovary@yahoo.com');
define('PRICE_JOURNEE',  1000);
define('PRICE_FULL_DAY', 1500);

if (session_status() === PHP_SESSION_NONE) session_start();
date_default_timezone_set('Europe/Paris');
