<?php
require_once 'config.php';
$current_page = 'home';
$page_title   = 'Accueil';
include 'includes/header.php';
?>

<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-palms"><span class="palm-left">🌴</span><span class="palm-right">🌴</span></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-left">
      <div class="hero-badge">🌴 Grand Événement</div>
      <h1 class="hero-title">
        <span class="line1">COCO</span>
        <span class="line2">ITALIA</span>
        <span class="line3">BEACH</span>
      </h1>
      <div class="hero-date">
        <span class="date-icon">📅</span>
        <span class="date-text">25 • 07 • 2026</span>
      </div>
      <div class="hero-address">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Strada Traversetolo 349A, Parma
      </div>
      <div class="hero-cta">
        <a href="<?= $R ?>pages/billetterie.php" class="btn btn-primary">🎟 Acheter un billet</a>
        <a href="<?= $R ?>pages/apropos.php" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,0.4)">En savoir plus</a>
      </div>
    </div>
    <div class="hero-right">
      <div class="hero-logo-big">
        <span class="hlb-coco">Coco</span>
        <span class="hlb-italia">ITALIA</span>
        <span class="hlb-beach">BEACH</span>
        <span class="hlb-parma">PARMA</span>
        <div class="hlb-tags">MUSIC · KARAOKÉ · BRAISES · CHICHA</div>
      </div>
    </div>
  </div>
</section>

<section class="info-strip">
  <div class="info-strip-grid">
    <div class="info-card">
      <h3>🎟 Tarifs</h3>
      <ul><li>Enfant : <strong style="color:var(--orange-light)">Gratuit</strong></li><li>Adulte : <strong>10€</strong></li></ul>
      <div class="price-big">15€</div>
      <p style="font-size:11px;color:rgba(255,255,255,0.4)">Entrée toute la journée</p>
    </div>
    <div class="info-card">
      <h3>🎧 DJ Invités</h3>
      <div class="dj-faces">
        <div class="dj-face"><div class="dj-avatar">S</div><span class="dj-name">Sénateur</span></div>
        <div class="dj-face"><div class="dj-avatar">A</div><span class="dj-name">Amelitho</span></div>
        <div class="dj-face"><div class="dj-avatar">W</div><span class="dj-name">Willy</span></div>
      </div>
    </div>
    <div class="info-card">
      <h3>🎮 Loisirs</h3>
      <ul><li>Espace jeux enfants & adultes</li><li>Cartes</li><li>PlayStation</li><li>Ludo</li></ul>
    </div>
    <div class="info-card">
      <h3>🏆 Lots à gagner</h3>
      <ul><li>Prime meilleur bikini</li><li>Prime meilleur chanteur/chanteuse</li></ul>
    </div>
    <div class="info-card">
      <h3>🚗 Services</h3>
      <ul><li>Service de passaggio disponible</li><li>B&amp;B sur réservation</li></ul>
    </div>
  </div>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="section-label">🎟 Réservez votre place</div>
    <h2 class="section-title dark">CHOISISSEZ VOTRE BILLET</h2>
    <p class="section-subtitle">Vivez une expérience unique au Coco Italia Beach !</p>
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
            <div class="ticket-perk"><span class="check">✓</span> Musique &amp; DJ live</div>
            <div class="ticket-perk"><span class="check">✓</span> Espace jeux</div>
            <div class="ticket-perk"><span class="check">✓</span> Billet numérique QR code</div>
          </div>
          <hr class="ticket-divider">
          <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="openPaymentModal('journee',10,'Entrée Journée')">🎟 Acheter — 10€</button>
        </div>
      </div>
      <div class="ticket-card featured">
        <div class="ticket-featured-badge">⭐ Meilleure offre</div>
        <div class="ticket-top">
          <div class="ticket-icon">🌴</div>
          <div class="ticket-type">Toute la Journée</div>
          <div class="ticket-tagline">Accès complet 10h–23h</div>
          <div class="ticket-price-block">
            <div class="ticket-price"><sup>€</sup>15</div>
            <div class="ticket-price-note">par adulte · Enfant gratuit</div>
          </div>
        </div>
        <div class="ticket-body">
          <div class="ticket-perks">
            <div class="ticket-perk"><span class="check">✓</span> Accès journée complète</div>
            <div class="ticket-perk"><span class="check">✓</span> Musique &amp; DJ live</div>
            <div class="ticket-perk"><span class="check">✓</span> Espace jeux &amp; loisirs</div>
            <div class="ticket-perk"><span class="check">✓</span> Participe aux concours</div>
            <div class="ticket-perk"><span class="check">✓</span> Billet numérique QR code</div>
          </div>
          <hr class="ticket-divider">
          <button class="btn btn-primary" style="width:100%;justify-content:center" onclick="openPaymentModal('full',15,'Entrée Toute la Journée')">🎟 Acheter — 15€</button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-label" style="color:var(--orange-light)">🎧 Sur scène</div>
    <h2 class="section-title light">NOS DJ INVITÉS</h2>
    <div class="djs-grid">
      <div class="dj-card"><div class="dj-card-avatar">S</div><div class="dj-card-name">DJ SÉNATEUR</div><div class="dj-card-title">Afrobeats &amp; Zouk</div></div>
      <div class="dj-card"><div class="dj-card-avatar">A</div><div class="dj-card-name">DJ AMELITHO</div><div class="dj-card-title">Afro &amp; Coupé-décalé</div></div>
      <div class="dj-card"><div class="dj-card-avatar">W</div><div class="dj-card-name">DJ WILLY</div><div class="dj-card-title">Mix International</div></div>
    </div>
  </div>
</section>

<section class="section" style="background:linear-gradient(135deg,#2D1A00,#4A2800)">
  <div class="container">
    <div class="section-label" style="color:var(--gold)">🏆 Concours</div>
    <h2 class="section-title light">LOTS À GAGNER</h2>
    <div class="lots-grid">
      <div class="lot-card"><div class="lot-icon">👙</div><div class="lot-title">Prime Meilleur Bikini</div><div class="lot-desc">Le plus beau look de l'été remporte un prix !</div></div>
      <div class="lot-card"><div class="lot-icon">🎤</div><div class="lot-title">Prime Meilleur Chanteur</div><div class="lot-desc">Montrez votre talent au karaoké et gagnez !</div></div>
      <div class="lot-card"><div class="lot-icon">🎶</div><div class="lot-title">Prime Meilleure Chanteuse</div><div class="lot-desc">Les meilleures voix seront récompensées</div></div>
      <div class="lot-card"><div class="lot-icon">🎁</div><div class="lot-title">Surprises &amp; Cadeaux</div><div class="lot-desc">Des surprises tout au long de la journée</div></div>
    </div>
  </div>
</section>

<div class="cta-banner">
  <h2>Vivez l'été comme jamais !</h2>
  <p>🌴 Coco Italia Beach · Parma · 25 Juillet 2026 🌴</p>
  <a href="<?= $R ?>pages/billetterie.php" class="btn btn-white">🎟 Réserver ma place maintenant</a>
</div>

<?php include 'includes/payment_modal.php'; ?>
<?php include 'includes/footer.php'; ?>
