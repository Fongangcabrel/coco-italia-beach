// =============================================
// COCO ITALIA BEACH — Main JS
// =============================================

document.addEventListener('DOMContentLoaded', function () {

  // ---- NAVBAR scroll effect ----
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
  });

  // ---- HAMBURGER MENU ----
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('nav-links');
  const overlay = document.getElementById('nav-overlay');

  function toggleMenu(open) {
    hamburger.classList.toggle('open', open);
    navLinks.classList.toggle('open', open);
    overlay.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  }

  if (hamburger) {
    hamburger.addEventListener('click', () => toggleMenu(!navLinks.classList.contains('open')));
  }
  if (overlay) {
    overlay.addEventListener('click', () => toggleMenu(false));
  }

  // Close menu on nav link click
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => toggleMenu(false));
  });

  // ---- SCROLL ANIMATIONS ----
  const animEls = document.querySelectorAll('.info-card, .ticket-card, .dj-card, .lot-card, .concept-card, .info-box, .contact-info-item');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.style.opacity = '1';
          e.target.style.transform = 'translateY(0)';
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.1 });

    animEls.forEach((el, i) => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(24px)';
      el.style.transition = `opacity 0.5s ease ${i * 0.07}s, transform 0.5s ease ${i * 0.07}s`;
      io.observe(el);
    });
  }

  // ---- MODAL PAYMENT ----
  window.openPaymentModal = function (type, price, label) {
    const modal = document.getElementById('payment-modal');
    if (!modal) return;
    document.getElementById('modal-ticket-type').textContent = label;
    document.getElementById('modal-ticket-price').textContent = price + '€';
    document.getElementById('hidden-ticket-type').value = type;
    document.getElementById('hidden-ticket-price').value = price;
    document.getElementById('qty-value').textContent = '1';
    updateTotal(price, 1);
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.closePaymentModal = function () {
    const modal = document.getElementById('payment-modal');
    if (modal) modal.classList.remove('open');
    document.body.style.overflow = '';
  };

  // Close modal on overlay click
  const modal = document.getElementById('payment-modal');
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closePaymentModal();
    });
  }

  // ESC key closes modal
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closePaymentModal();
  });

  // ---- QUANTITY SELECTOR ----
  function updateTotal(price, qty) {
    const total = price * qty;
    const totalEl = document.getElementById('qty-total');
    if (totalEl) totalEl.textContent = 'Total : ' + total + '€';
    const priceInput = document.getElementById('hidden-ticket-price');
    if (priceInput) priceInput.value = total;
  }

  window.changeQty = function (delta) {
    const display = document.getElementById('qty-value');
    if (!display) return;
    let qty = parseInt(display.textContent) + delta;
    if (qty < 1) qty = 1;
    if (qty > 10) qty = 10;
    display.textContent = qty;
    const price = parseInt(document.getElementById('hidden-ticket-price-unit')?.value || 10);
    updateTotal(price, qty);
  };

  // ---- CONTACT FORM AJAX ----
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn = contactForm.querySelector('.btn-submit');
      const alertSuccess = document.getElementById('contact-success');
      const alertError = document.getElementById('contact-error');

      btn.disabled = true;
      btn.innerHTML = '<div class="spinner"></div> Envoi en cours...';

      const data = new FormData(contactForm);

      fetch('/pages/contact_send.php', {
        method: 'POST',
        body: data
      })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            alertSuccess.classList.add('show');
            alertError.classList.remove('show');
            contactForm.reset();
          } else {
            alertError.textContent = res.message || 'Une erreur est survenue.';
            alertError.classList.add('show');
            alertSuccess.classList.remove('show');
          }
        })
        .catch(() => {
          alertError.textContent = 'Erreur réseau. Veuillez réessayer.';
          alertError.classList.add('show');
        })
        .finally(() => {
          btn.disabled = false;
          btn.innerHTML = '✉️ Envoyer le message';
        });
    });
  }

  // ---- SMOOTH SCROLL for anchor links ----
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

});
