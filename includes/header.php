<?php
// Calcul profondeur relative vers la racine
$_root_dir  = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$_cur_file  = str_replace('\\', '/', realpath($_SERVER['SCRIPT_FILENAME'] ?? __FILE__));
$_cur_dir   = dirname($_cur_file);
$_depth     = ($_cur_dir !== $_root_dir) ? 1 : 0;
$R          = str_repeat('../', $_depth); // '' si racine, '../' si sous-dossier
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — ' : '' ?>Coco Italia Beach · Parma 2026</title>
    <meta name="description" content="Grand événement Coco Italia Beach le 25 juillet 2026 à Parma. Music, Karaoké, Braises, Chicha.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700;800&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $R ?>assets/css/main.css">
</head>
<body class="<?= isset($body_class) ? $body_class : '' ?>">

<nav class="navbar" id="navbar">
  <div class="nav-container">

    <a href="<?= $R ?>index.php" class="nav-logo">
      <div class="logo-circle">
        <span class="logo-top">COCO</span>
        <span class="logo-sub">ITALIA BEACH</span>
        <span class="logo-mini">PARMA</span>
      </div>
    </a>

    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>

    <ul class="nav-links" id="nav-links">
      <li><a href="<?= $R ?>index.php"              class="<?= ($current_page??'')==='home'       ? 'active':'' ?>">Accueil</a></li>
      <li><a href="<?= $R ?>pages/apropos.php"      class="<?= ($current_page??'')==='apropos'    ? 'active':'' ?>">À Propos</a></li>
      <li><a href="<?= $R ?>pages/billetterie.php"  class="<?= ($current_page??'')==='billetterie'? 'active':'' ?>">Billetterie</a></li>
      <li><a href="<?= $R ?>pages/infos.php"        class="<?= ($current_page??'')==='infos'      ? 'active':'' ?>">Infos Pratiques</a></li>
      <li><a href="<?= $R ?>pages/contact.php"      class="<?= ($current_page??'')==='contact'    ? 'active':'' ?>">Contact</a></li>
      <li style="padding:16px 24px 0">
        <a href="<?= $R ?>pages/billetterie.php" class="btn btn-primary" style="width:100%;justify-content:center;font-size:13px;padding:12px 20px">
          🎟 Acheter un billet
        </a>
      </li>
    </ul>

    <a href="<?= $R ?>pages/billetterie.php" class="btn-nav-ticket">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
      Acheter un billet
    </a>

  </div>
</nav>
