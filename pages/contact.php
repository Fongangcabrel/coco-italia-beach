<?php
require_once '../config.php';
$current_page = 'contact';
$page_title   = 'Contact';
include '../includes/header.php';
?>
<section class="page-hero">
  <div class="page-hero-label">📬 Contactez-nous</div>
  <h1>CONTACT</h1>
  <p>Une question ? Contactez-nous !</p>
</section>

<section class="section" style="background:var(--cream)">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-form-box">
        <h3>ÉCRIVEZ-NOUS</h3>
        <div class="alert alert-success" id="contact-success">✅ Message envoyé ! Nous vous répondrons rapidement.</div>
        <div class="alert alert-error"   id="contact-error">Une erreur est survenue.</div>
        <form id="contact-form" novalidate>
          <div class="form-group">
            <label class="form-label">Nom complet *</label>
            <input type="text" class="form-input" name="nom" placeholder="Votre nom complet" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" class="form-input" name="email" placeholder="votre@email.com" required>
          </div>
          <div class="form-group">
            <label class="form-label">Sujet</label>
            <select class="form-input" name="sujet">
              <option value="">Choisissez un sujet</option>
              <option value="billet">Question sur les billets</option>
              <option value="transport">Transport / Passaggio</option>
              <option value="hebergement">Hébergement B&amp;B</option>
              <option value="partenariat">Partenariat / Sponsoring</option>
              <option value="autre">Autre</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Message *</label>
            <textarea class="form-input" name="message" rows="5" placeholder="Écrivez votre message ici..." required style="resize:vertical"></textarea>
          </div>
          <button type="submit" class="btn-submit">✉️ Envoyer le message</button>
        </form>
      </div>

      <div class="contact-info-box">
        <?php
        $coords = [
          ['✉️','Email','c.bovary@yahoo.com'],
          ['📞','Téléphone / WhatsApp','+39 350 123 4567'],
          ['📍','Adresse événement','Strada Traversetolo 349A, Parma'],
          ['🕐','Disponibilité','Lun – Sam · 9h00 – 20h00'],
        ];
        foreach($coords as $c): ?>
        <div class="contact-info-item">
          <div class="contact-info-icon"><?= $c[0] ?></div>
          <div>
            <div class="contact-info-label"><?= $c[1] ?></div>
            <div class="contact-info-value"><?= $c[2] ?></div>
          </div>
        </div>
        <?php endforeach; ?>

        <div class="contact-social">
          <h4>SUIVEZ-NOUS !</h4>
          <p>Restez connectés pour toutes les nouveautés et surprises</p>
          <div class="social-buttons">
            <a href="#" class="social-btn instagram">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              @coco_italia_beach
            </a>
            <a href="#" class="social-btn facebook">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              Coco Italia Beach
            </a>
            <a href="#" class="social-btn tiktok">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
              TikTok
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('contact-form');
  if (!form) return;
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = form.querySelector('.btn-submit');
    var ok  = document.getElementById('contact-success');
    var err = document.getElementById('contact-error');
    btn.disabled = true;
    btn.textContent = 'Envoi en cours...';
    fetch('contact_send.php', { method:'POST', body: new FormData(form) })
      .then(function(r){ return r.json(); })
      .then(function(res){
        if (res.success) { ok.classList.add('show'); err.classList.remove('show'); form.reset(); }
        else { err.textContent = res.message||'Erreur.'; err.classList.add('show'); ok.classList.remove('show'); }
      })
      .catch(function(){ err.textContent='Erreur réseau.'; err.classList.add('show'); })
      .finally(function(){ btn.disabled=false; btn.textContent='✉️ Envoyer le message'; });
  });
});
</script>

<?php include '../includes/footer.php'; ?>
