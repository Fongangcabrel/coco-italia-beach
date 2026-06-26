<?php
require_once '../config.php';
$current_page = 'infos';
$page_title   = 'Infos Pratiques';
include '../includes/header.php';
?>
<section class="page-hero">
  <div class="page-hero-label">ℹ️ Tout savoir</div>
  <h1>INFOS PRATIQUES</h1>
  <p>Tout ce qu'il faut savoir pour profiter à 100% !</p>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-label">📋 Informations essentielles</div>
    <h2 class="section-title dark">L'ÉVÉNEMENT EN UN COUP D'ŒIL</h2>
    <div class="infos-grid">
      <?php
      $infos = [
        ['📅','Date','25 juillet 2026','Samedi — toute la journée'],
        ['📍','Lieu','Strada Traversetolo 349A','Parma, Italie'],
        ['🕐','Horaires','10h00 – 23h00','Ouverture des portes à 10h00'],
        ['🎟','Tarifs','10€ / 15€ · Enfant gratuit','Journée ou accès complet'],
        ['🚗','Accès','Service de passaggio disponible','Parking gratuit sur place'],
        ['🏨','Hébergement','B&B sur réservation','Plus d\'infos sur demande'],
      ];
      foreach($infos as $i): ?>
      <div class="info-box">
        <div class="info-box-icon"><?= $i[0] ?></div>
        <div>
          <div class="info-box-label"><?= $i[1] ?></div>
          <div class="info-box-value"><?= $i[2] ?></div>
          <div class="info-box-sub"><?= $i[3] ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-label" style="color:var(--orange-light)">🎒 Checklist</div>
    <h2 class="section-title light">À PRÉVOIR</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;margin-top:40px">
      <?php
      $items = [
        ['☀️','Crème solaire','Indispensable pour profiter du soleil toute la journée'],
        ['👙','Maillot de bain','Pour l\'ambiance plage et les activités'],
        ['😄','Bonne humeur','L\'ingrédient principal pour une journée parfaite !'],
        ['⚡','Énergie','Venez reposés — on va danser jusqu\'au bout !'],
        ['📱','Votre billet QR','Téléchargez votre billet PDF avant de venir'],
        ['💧','S\'hydrater','Pensez à boire de l\'eau tout au long de la journée'],
      ];
      foreach($items as $item): ?>
      <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(244,124,32,0.2);border-radius:16px;padding:24px;display:flex;gap:16px;align-items:flex-start">
        <span style="font-size:32px"><?= $item[0] ?></span>
        <div>
          <div style="font-weight:700;color:#fff;margin-bottom:4px"><?= $item[1] ?></div>
          <div style="font-size:13px;color:rgba(255,255,255,0.55);line-height:1.6"><?= $item[2] ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="background:#fff">
  <div class="container">
    <div class="section-label">⏰ Planning</div>
    <h2 class="section-title dark">PROGRAMME DE LA JOURNÉE</h2>
    <div style="max-width:600px;margin-top:40px">
      <?php
      $programme = [
        ['10h00','Ouverture des portes','Accueil des participants'],
        ['11h00','Début de l\'ambiance','Premiers sets DJ, animations'],
        ['12h00','Braises & Déjeuner','Grillades, restauration sur place'],
        ['14h00','Concours & Animations','Karaoké, concours meilleur bikini'],
        ['17h00','DJ Sets principaux','DJ Sénateur, DJ Amelitho'],
        ['20h00','Dîner & Chicha','Ambiance soirée, espace chicha'],
        ['21h00','Grand finale','DJ Willy — clôture en beauté'],
        ['23h00','Fermeture','Fin de l\'événement'],
      ];
      foreach($programme as $i => $p): ?>
      <div style="display:flex;gap:24px;padding:20px 0;border-bottom:<?= $i===count($programme)-1?'none':'1px solid rgba(0,0,0,0.06)' ?>">
        <div style="min-width:64px;font-family:'Bebas Neue',cursive;font-size:20px;color:var(--orange)"><?= $p[0] ?></div>
        <div>
          <div style="font-weight:700;color:var(--brown-dark);margin-bottom:2px"><?= $p[1] ?></div>
          <div style="font-size:13px;color:var(--text-gray)"><?= $p[2] ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-label">📜 À savoir</div>
    <h2 class="section-title dark">RÈGLEMENT</h2>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-top:40px">
      <div style="background:#fff;border-radius:20px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.06)">
        <h3 style="font-family:'Bebas Neue',cursive;font-size:24px;color:var(--brown-dark);margin-bottom:16px">✅ Autorisé</h3>
        <ul style="display:flex;flex-direction:column;gap:10px">
          <?php foreach(['Appareil photo personnel','Petites enceintes discrètes','Pique-nique personnel','Enfants (avec adulte)','Animaux tenus en laisse'] as $it): ?>
          <li style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--text-gray)"><span style="color:#22c55e">✓</span><?= $it ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div style="background:#fff;border-radius:20px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.06)">
        <h3 style="font-family:'Bebas Neue',cursive;font-size:24px;color:var(--brown-dark);margin-bottom:16px">❌ Non autorisé</h3>
        <ul style="display:flex;flex-direction:column;gap:10px">
          <?php foreach(['Armes de toute nature','Drones sans autorisation','Comportements agressifs','Revente non officielle de billets','Alcool apporté de l\'extérieur'] as $it): ?>
          <li style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--text-gray)"><span style="color:#ef4444">✗</span><?= $it ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<div class="cta-banner">
  <h2>On vous attend nombreux pour faire la fête ensemble !</h2>
  <p>🌴 25 Juillet 2026 · Parma, Italie 🌴</p>
  <a href="billetterie.php" class="btn btn-white">🎟 Réserver ma place</a>
</div>

<?php include '../includes/payment_modal.php'; ?>
<?php include '../includes/footer.php'; ?>
