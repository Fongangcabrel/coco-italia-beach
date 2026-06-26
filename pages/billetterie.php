<?php
require_once '../config.php';
$current_page = 'billetterie';
$page_title   = 'Billetterie';
include '../includes/header.php';
?>
<section class="page-hero">
  <div class="page-hero-label">🎟 Réservations</div>
  <h1>BILLETTERIE</h1>
  <p>Réservez votre place pour la plus grande beach party de l'été !</p>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <div class="section-label">🌴 Choisissez votre formule</div>
      <h2 class="section-title dark">CHOISISSEZ VOTRE BILLET</h2>
      <p class="section-subtitle" style="margin:0 auto">Paiement 100% sécurisé. Billet numérique reçu par email.</p>
    </div>
    <div class="tickets-grid">
      <div class="ticket-card">
        <div class="ticket-top">
          <div class="ticket-icon">☀️</div>
          <div class="ticket-type">Entrée Journée</div>
          <div class="ticket-tagline">Profitez de la journée</div>
          <div class="ticket-price-block">
            <div class="ticket-price"><sup>€</sup>10</div>
            <div class="ticket-price-note">par adulte · Enfant gratuit</div>
          </div>
        </div>
        <div class="ticket-body">
          <div class="ticket-perks">
            <div class="ticket-perk"><span class="check">✓</span> Accès à l'événement</div>
            <div class="ticket-perk"><span class="check">✓</span> Musique &amp; DJ sets live</div>
            <div class="ticket-perk"><span class="check">✓</span> Espace jeux (cartes, Ludo…)</div>
            <div class="ticket-perk"><span class="check">✓</span> PlayStation disponible</div>
            <div class="ticket-perk"><span class="check">✓</span> Billet numérique PDF + QR code</div>
          </div>
          <hr class="ticket-divider">
          <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="openPaymentModal('journee',10,'Entrée Journée')">🎟 Sélectionner — 10€</button>
        </div>
      </div>
      <div class="ticket-card featured">
        <div class="ticket-featured-badge">⭐ Meilleure offre</div>
        <div class="ticket-top">
          <div class="ticket-icon">🌴</div>
          <div class="ticket-type">Toute la Journée</div>
          <div class="ticket-tagline">Accès complet 10h00 – 23h00</div>
          <div class="ticket-price-block">
            <div class="ticket-price"><sup>€</sup>15</div>
            <div class="ticket-price-note">par adulte · Enfant gratuit</div>
          </div>
        </div>
        <div class="ticket-body">
          <div class="ticket-perks">
            <div class="ticket-perk"><span class="check">✓</span> Accès journée complète 10h–23h</div>
            <div class="ticket-perk"><span class="check">✓</span> Musique &amp; DJ sets live</div>
            <div class="ticket-perk"><span class="check">✓</span> Espace jeux &amp; loisirs</div>
            <div class="ticket-perk"><span class="check">✓</span> Karaoké &amp; concours</div>
            <div class="ticket-perk"><span class="check">✓</span> Participation aux lots</div>
            <div class="ticket-perk"><span class="check">✓</span> Billet numérique PDF + QR code</div>
          </div>
          <hr class="ticket-divider">
          <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="openPaymentModal('full',15,'Entrée Toute la Journée')">🎟 Sélectionner — 15€</button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <div class="section-label" style="color:var(--orange-light)">📋 Simple &amp; rapide</div>
      <h2 class="section-title light">COMMENT ÇA MARCHE ?</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:32px">
      <?php
      $steps = [
        ['1','🎫','Choisissez votre billet','Journée ou toute la journée'],
        ['2','💳','Payez en ligne','100% sécurisé via Stripe'],
        ['3','📧','Recevez votre billet','PDF + QR code par email'],
        ['4','📱','Présentez le QR code','Scan à l\'entrée — c\'est tout !'],
      ];
      foreach($steps as $s): ?>
      <div style="text-align:center">
        <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--orange-light),var(--orange-dark));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:'Bebas Neue',cursive;font-size:28px;color:#fff;box-shadow:0 8px 24px rgba(244,124,32,0.4)"><?= $s[0] ?></div>
        <div style="font-size:32px;margin-bottom:8px"><?= $s[1] ?></div>
        <div style="font-weight:700;color:#fff;font-size:15px;margin-bottom:6px"><?= $s[2] ?></div>
        <div style="font-size:13px;color:rgba(255,255,255,0.5);line-height:1.6"><?= $s[3] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="background:#fff">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px">
      <div class="section-label">🛡️ Nos garanties</div>
      <h2 class="section-title dark">ACHAT SÉCURISÉ</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px">
      <?php
      $garanties = [
        ['🔒','Paiement Sécurisé','100% sécurisé par carte bancaire via Stripe'],
        ['📧','Billet Numérique','PDF avec QR code envoyé instantanément par email'],
        ['⚡','Accès Rapide','Scannez votre QR code à l\'entrée'],
        ['🔄','Remboursement','Possible jusqu\'à 30 jours avant l\'événement'],
      ];
      foreach($garanties as $g): ?>
      <div style="text-align:center;padding:28px 20px;background:var(--cream);border-radius:20px">
        <div style="font-size:40px;margin-bottom:12px"><?= $g[0] ?></div>
        <div style="font-weight:700;color:var(--brown-dark);margin-bottom:6px"><?= $g[1] ?></div>
        <div style="font-size:13px;color:var(--text-gray)"><?= $g[2] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="cta-banner">
  <h2>On vous attend nombreux !</h2>
  <p>🌴 25 Juillet 2026 · Strada Traversetolo 349A, Parma 🌴</p>
  <button onclick="openPaymentModal('full',15,'Entrée Toute la Journée')" class="btn btn-white">🎟 Acheter mon billet maintenant</button>
</div>

<?php include '../includes/payment_modal.php'; ?>
<?php include '../includes/footer.php'; ?>
