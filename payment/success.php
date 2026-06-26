<?php
require_once '../config.php';
$current_page = '';
$page_title   = 'Paiement réussi';
$order = $_SESSION['pending_order'] ?? null;
unset($_SESSION['pending_order']);
include '../includes/header.php';
?>
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--cream);padding:100px 24px 40px">
  <div style="max-width:560px;width:100%;text-align:center">
    <div style="width:80px;height:80px;background:#D1FAE5;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:40px;margin:0 auto 24px;box-shadow:0 8px 24px rgba(34,197,94,0.3)">✅</div>
    <h1 style="font-family:'Bebas Neue',cursive;font-size:48px;color:var(--brown-dark);margin-bottom:8px">PAIEMENT RÉUSSI !</h1>
    <p style="font-size:18px;color:var(--text-gray);margin-bottom:32px">Merci pour votre réservation 🌴</p>

    <?php if ($order): ?>
    <div style="background:#fff;border-radius:20px;padding:32px;box-shadow:0 4px 16px rgba(0,0,0,0.08);margin-bottom:32px;text-align:left">
      <h3 style="font-family:'Bebas Neue',cursive;font-size:24px;color:var(--brown-dark);margin-bottom:20px;text-align:center">📋 RÉCAPITULATIF</h3>
      <?php
      $rows = [
        ['Nom',          htmlspecialchars(($order['prenom']??'').' '.($order['nom']??''))],
        ['Email',        htmlspecialchars($order['email']??'')],
        ['Billet',       ($order['ticket_type']??'')==='full' ? 'Entrée Toute la Journée' : 'Entrée Journée'],
        ['Quantité',     ($order['quantity']??1).' billet(s)'],
        ['Total payé',   (($order['amount']??0)/100).'€'],
        ['Événement',    '25 juillet 2026 — Parma'],
      ];
      foreach($rows as $row): ?>
      <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.06);font-size:14px">
        <span style="color:var(--text-gray)"><?= $row[0] ?></span>
        <strong style="color:var(--brown-dark)"><?= $row[1] ?></strong>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div style="background:linear-gradient(135deg,var(--brown-dark),var(--brown));border-radius:20px;padding:28px;margin-bottom:24px">
      <div style="font-size:32px;margin-bottom:12px">📧</div>
      <h3 style="font-family:'Bebas Neue',cursive;font-size:24px;color:#fff;margin-bottom:8px">VOTRE BILLET PAR EMAIL</h3>
      <p style="color:rgba(255,255,255,0.7);font-size:14px;line-height:1.7">
        Un email de confirmation avec votre billet PDF et QR code a été envoyé.<br>
        <strong style="color:var(--orange-light)">Pensez à vérifier vos spams.</strong>
      </p>
    </div>

    <div style="background:#FFF9F0;border:2px solid rgba(244,124,32,0.2);border-radius:16px;padding:20px;margin-bottom:32px">
      <div style="font-size:24px;margin-bottom:8px">📍</div>
      <strong style="color:var(--brown-dark)">Strada Traversetolo 349A, Parma</strong><br>
      <span style="font-size:13px;color:var(--text-gray)">Samedi 25 juillet 2026 · Ouverture 10h00</span>
    </div>

    <div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center">
      <a href="<?= $R ?>index.php" class="btn btn-outline">← Retour à l'accueil</a>
      <a href="<?= $R ?>pages/infos.php" class="btn btn-primary">📋 Infos pratiques</a>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
