<?php if (!isset($R)) { $R = (dirname(str_replace('\\','/',realpath($_SERVER['SCRIPT_FILENAME']??__FILE__))) !== str_replace('\\','/',realpath(__DIR__.'/..')))?'../':''; } ?>
<div class="modal-overlay" id="payment-modal">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-title">🎟 RÉSERVER UN BILLET</div>
        <div class="modal-subtitle">Paiement 100% sécurisé par Stripe</div>
      </div>
      <button class="modal-close" onclick="closePaymentModal()">✕</button>
    </div>
    <div class="modal-body">
      <div class="ticket-summary">
        <div>
          <div class="ticket-summary-label">Type de billet</div>
          <div class="ticket-summary-type" id="modal-ticket-type">Entrée Journée</div>
        </div>
        <div class="ticket-summary-price" id="modal-ticket-price">10€</div>
      </div>
      <form id="payment-form">
        <input type="hidden" name="ticket_type"       id="hidden-ticket-type"       value="journee">
        <input type="hidden" name="ticket_price"      id="hidden-ticket-price"      value="10">
        <input type="hidden" name="ticket_price_unit" id="hidden-ticket-price-unit" value="10">
        <input type="hidden" name="quantity"          id="qty-hidden"               value="1">

        <div class="form-group">
          <label class="form-label">Nombre de billets adultes</label>
          <div class="qty-selector">
            <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
            <div class="qty-display" id="qty-value">1</div>
            <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
          </div>
          <div class="qty-total" id="qty-total">Total : 10€</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Prénom *</label>
            <input type="text" class="form-input" name="prenom" placeholder="Votre prénom" required>
          </div>
          <div class="form-group">
            <label class="form-label">Nom *</label>
            <input type="text" class="form-input" name="nom" placeholder="Votre nom" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Email *</label>
          <input type="email" class="form-input" name="email" placeholder="votre@email.com" required>
          <small style="color:var(--text-gray);font-size:11px;margin-top:4px;display:block">Votre billet PDF sera envoyé ici</small>
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone</label>
          <input type="tel" class="form-input" name="telephone" placeholder="+39 350 000 0000">
        </div>

        <div class="payment-secure">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Paiement sécurisé — Redirigé vers Stripe
        </div>

        <div id="payment-errors" style="background:#FEE2E2;border:1px solid #FCA5A5;color:#DC2626;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:none"></div>

        <button type="submit" class="btn-pay" id="pay-btn">
          🔒 Payer en toute sécurité
        </button>

        <p style="text-align:center;font-size:11px;color:var(--text-gray);margin-top:12px">
          Remboursement possible jusqu'à 30 jours avant l'événement.
        </p>
      </form>
    </div>
  </div>
</div>

<script>
(function(){
  var BASE = '<?= $R ?>';

  window.openPaymentModal = function(type, price, label) {
    document.getElementById('modal-ticket-type').textContent  = label;
    document.getElementById('modal-ticket-price').textContent = price + '€';
    document.getElementById('hidden-ticket-type').value       = type;
    document.getElementById('hidden-ticket-price').value      = price;
    document.getElementById('hidden-ticket-price-unit').value = price;
    document.getElementById('qty-value').textContent          = '1';
    document.getElementById('qty-hidden').value               = '1';
    document.getElementById('qty-total').textContent          = 'Total : ' + price + '€';
    document.getElementById('payment-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.closePaymentModal = function() {
    document.getElementById('payment-modal').classList.remove('open');
    document.body.style.overflow = '';
  };

  window.changeQty = function(delta) {
    var display = document.getElementById('qty-value');
    var qty = Math.min(10, Math.max(1, parseInt(display.textContent) + delta));
    var unit = parseInt(document.getElementById('hidden-ticket-price-unit').value);
    display.textContent = qty;
    document.getElementById('qty-hidden').value = qty;
    document.getElementById('hidden-ticket-price').value = unit * qty;
    document.getElementById('qty-total').textContent = 'Total : ' + (unit * qty) + '€';
  };

  document.addEventListener('DOMContentLoaded', function() {
    var overlay = document.getElementById('payment-modal');
    if (overlay) overlay.addEventListener('click', function(e){ if(e.target===overlay) closePaymentModal(); });

    var form = document.getElementById('payment-form');
    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('pay-btn');
        var err = document.getElementById('payment-errors');
        err.style.display = 'none';
        btn.disabled = true;
        btn.innerHTML = '<div class="spinner"></div>&nbsp;Redirection vers Stripe...';
        var data = new FormData(form);
        data.set('quantity', document.getElementById('qty-value').textContent);
        fetch(BASE + 'payment/create_checkout.php', { method:'POST', body:data })
          .then(function(r){ return r.json(); })
          .then(function(res){
            if (res.url) { window.location.href = res.url; }
            else {
              err.textContent = res.error || 'Erreur lors du paiement.';
              err.style.display = 'block';
              btn.disabled = false;
              btn.innerHTML = '🔒 Payer en toute sécurité';
            }
          })
          .catch(function(){
            err.textContent = 'Erreur réseau. Veuillez réessayer.';
            err.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '🔒 Payer en toute sécurité';
          });
      });
    }
  });
})();
</script>
