<?php
require_once '../config.php';
$current_page = 'apropos';
$page_title   = 'À Propos';
include '../includes/header.php';
?>
<section class="page-hero">
  <div class="page-hero-label">✨ Notre histoire</div>
  <h1>À PROPOS</h1>
  <p>Plus qu'un événement, une expérience inoubliable !</p>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="about-intro">
      <div class="about-text">
        <div class="section-label">🌴 Coco Italia Beach</div>
        <h2 class="section-title dark">QUI SOMMES-NOUS ?</h2>
        <p>C'est la rencontre entre la chaleur de l'été, l'ambiance festive et la convivialité. Une journée exceptionnelle où la musique, les loisirs et la bonne humeur s'unissent pour vous offrir des souvenirs mémorables.</p>
        <p>Né de la passion pour la fête et le partage, <strong>Coco Italia Beach</strong> est bien plus qu'un simple événement. C'est un espace de vie, de rencontre, de culture et de célébration — à Parma, au cœur de l'Italie.</p>
        <p>Pour cette édition, nous vous promettons une journée complète du matin au soir, avec de la musique live, des animations, des concours, de la bonne nourriture et des moments de bonheur à partager avec vos proches.</p>
        <a href="billetterie.php" class="btn btn-primary" style="margin-top:16px">🎟 Réserver ma place</a>
      </div>
      <div class="about-visual">
        <div class="about-visual-title">Coco</div>
        <div class="about-visual-sub">ITALIA BEACH</div>
        <div style="color:rgba(255,255,255,0.5);font-size:13px;margin:8px 0">📅 25 Juillet 2026</div>
        <div style="background:var(--orange);display:inline-block;padding:4px 20px;border-radius:4px;color:#fff;font-size:12px;font-weight:700;letter-spacing:3px;margin:8px 0">PARMA</div>
        <div class="about-visual-tags">MUSIC · KARAOKÉ · BRAISES · CHICHA</div>
      </div>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="section-label" style="color:var(--orange-light)">🎯 Ce que nous offrons</div>
    <h2 class="section-title light">NOTRE CONCEPT</h2>
    <div class="concept-grid">
      <?php
      $concepts = [
        ['🎵','Musique','Live & DJ sets toute la journée avec des artistes de talent'],
        ['🎮','Loisirs','Pour petits et grands : jeux, PlayStation, cartes, ludo'],
        ['❤️','Convivialité','Partage et bonne humeur dans une ambiance chaleureuse'],
        ['🏖️','Détente','Plage, soleil et fun — l\'été à son meilleur'],
        ['🍖','Braises','Grillades et saveurs pour régaler vos papilles'],
        ['💨','Chicha','Espace chicha convivial pour se détendre entre amis'],
        ['🎤','Karaoké','Montez sur scène et montrez votre talent !'],
        ['🏆','Concours','Participez et tentez de remporter de beaux lots'],
      ];
      foreach($concepts as $c): ?>
      <div class="concept-card">
        <div class="concept-icon"><?= $c[0] ?></div>
        <div class="concept-title"><?= $c[1] ?></div>
        <div class="concept-desc"><?= $c[2] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" style="background:linear-gradient(135deg,#2D1A00,#4A2800)">
  <div class="container">
    <div class="section-label" style="color:var(--gold)">🎧 Ils seront là</div>
    <h2 class="section-title light">NOS DJ INVITÉS</h2>
    <div class="djs-grid">
      <div class="dj-card">
        <div class="dj-card-avatar">S</div>
        <div class="dj-card-name">DJ SÉNATEUR</div>
        <div class="dj-card-title">Afrobeats · Zouk · Ndombolo</div>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:12px;line-height:1.6">Un DJ aux multiples talents, reconnu pour ses sets électrisants</p>
      </div>
      <div class="dj-card">
        <div class="dj-card-avatar">A</div>
        <div class="dj-card-name">DJ AMELITHO</div>
        <div class="dj-card-title">Afro · Coupé-décalé · Mapouka</div>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:12px;line-height:1.6">Spécialiste des rythmes africains, il vous fera danser sans souffler</p>
      </div>
      <div class="dj-card">
        <div class="dj-card-avatar">W</div>
        <div class="dj-card-name">DJ WILLY</div>
        <div class="dj-card-title">Mix International · House · Afropop</div>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:12px;line-height:1.6">Un mix éclectique qui satisfera tous les goûts musicaux</p>
      </div>
    </div>
  </div>
</section>

<div class="cta-banner">
  <h2>Ne manquez pas l'événement de l'été !</h2>
  <p>🌴 Rejoignez-nous le 25 juillet 2026 à Parma 🌴</p>
  <a href="billetterie.php" class="btn btn-white">🎟 Acheter mon billet</a>
</div>

<?php include '../includes/payment_modal.php'; ?>
<?php include '../includes/footer.php'; ?>
