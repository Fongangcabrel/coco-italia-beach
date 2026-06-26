<?php
require_once '../config.php';

// Gestion login/logout
if (isset($_POST['logout'])) {
    unset($_SESSION['scan_auth']);
}
if (isset($_POST['password'])) {
    if ($_POST['password'] === SCAN_PASSWORD) {
        $_SESSION['scan_auth'] = true;
    } else {
        $login_error = 'Mot de passe incorrect.';
    }
}

$authenticated = !empty($_SESSION['scan_auth']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Validation Billets — Coco Italia Beach</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:sans-serif; background:#1a0f08; color:#fff; min-height:100vh; }

        .login-wrap { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px; }
        .login-box  { background:#2a1a0e; border-radius:16px; padding:40px; width:100%; max-width:360px; text-align:center; }
        .login-box h1 { font-size:22px; margin-bottom:8px; }
        .login-box p  { color:rgba(255,255,255,0.5); font-size:13px; margin-bottom:28px; }
        .login-box input { width:100%; padding:12px 16px; border-radius:8px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.08); color:#fff; font-size:16px; margin-bottom:12px; }
        .login-box button { width:100%; padding:13px; background:#F47C20; border:none; border-radius:8px; color:#fff; font-size:16px; font-weight:700; cursor:pointer; }
        .login-error { background:#7f1d1d; color:#fca5a5; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:16px; }

        .wrap { max-width:480px; margin:0 auto; padding:20px; }
        .header { display:flex; justify-content:space-between; align-items:center; padding:16px 0; margin-bottom:24px; }
        .header h1 { font-size:18px; }
        .top-btn { background:rgba(255,255,255,0.1); border:none; color:#fff; padding:7px 14px; border-radius:6px; font-size:13px; cursor:pointer; text-decoration:none; display:inline-block; }
        .top-btn:hover { background:rgba(255,255,255,0.18); }

        .code-input-box { background:#2a1a0e; border-radius:16px; padding:28px 24px; margin-bottom:20px; }
        .code-input-box label { display:block; font-size:12px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px; }
        .code-input { width:100%; padding:16px; background:rgba(255,255,255,0.08); border:2px solid rgba(255,255,255,0.15); border-radius:10px; color:#fff; font-size:24px; font-family:monospace; font-weight:700; letter-spacing:4px; text-align:center; text-transform:uppercase; transition:border-color .2s; }
        .code-input:focus { outline:none; border-color:#F47C20; }
        .code-input::placeholder { color:rgba(255,255,255,0.2); letter-spacing:2px; font-size:16px; }
        .verify-btn { margin-top:14px; width:100%; padding:15px; background:#F47C20; border:none; border-radius:10px; color:#fff; font-size:16px; font-weight:700; cursor:pointer; }
        .verify-btn:hover { background:#d96a10; }
        .verify-btn:disabled { background:#555; cursor:not-allowed; }

        .result-box { border-radius:14px; padding:24px; display:none; margin-bottom:20px; }
        .result-box.valid   { background:#064e3b; border:2px solid #10b981; }
        .result-box.invalid { background:#7f1d1d; border:2px solid #ef4444; }
        .result-box.already { background:#78350f; border:2px solid #f59e0b; }
        .result-icon  { font-size:52px; text-align:center; margin-bottom:12px; }
        .result-title { font-size:22px; font-weight:700; text-align:center; margin-bottom:18px; }
        .result-row   { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid rgba(255,255,255,0.1); font-size:14px; }
        .result-row:last-child { border:none; }
        .result-label { color:rgba(255,255,255,0.55); }
        .again-btn { margin-top:18px; width:100%; padding:12px; background:rgba(255,255,255,0.12); border:none; color:#fff; border-radius:8px; font-size:15px; cursor:pointer; }

        .stats-bar { background:#2a1a0e; border-radius:12px; padding:14px 20px; display:flex; justify-content:space-between; align-items:center; font-size:13px; color:rgba(255,255,255,0.5); }
        .stats-bar strong { color:#F47C20; font-size:20px; }
    </style>
</head>
<body>

<?php if (!$authenticated): ?>
<div class="login-wrap">
    <div class="login-box">
        <div style="font-size:40px;margin-bottom:12px">🎟</div>
        <h1>Accès Staff</h1>
        <p>Coco Italia Beach · 25 juillet 2026</p>
        <?php if (!empty($login_error)): ?>
            <div class="login-error"><?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="Mot de passe staff" autofocus required>
            <button type="submit">Accéder</button>
        </form>
    </div>
</div>

<?php else: ?>
<div class="wrap">
    <div class="header">
        <h1>🎟 Validation billets</h1>
        <div style="display:flex;gap:8px">
            <a href="scan_stats.php" class="top-btn">📊 Stats</a>
            <form method="POST" style="display:inline">
                <button name="logout" value="1" class="top-btn">Quitter</button>
            </form>
        </div>
    </div>

    <div class="result-box" id="result-box">
        <div class="result-icon" id="result-icon"></div>
        <div class="result-title" id="result-title"></div>
        <div id="result-details"></div>
        <button class="again-btn" onclick="reset()">→ Valider un autre billet</button>
    </div>

    <div class="code-input-box" id="input-box">
        <label>Code du billet</label>
        <input type="text" id="code-input" class="code-input" placeholder="XXXX-XXXX" maxlength="9" autocomplete="off" autocorrect="off" spellcheck="false">
        <button class="verify-btn" id="verify-btn" onclick="verify()">Valider le billet</button>
    </div>

    <div class="stats-bar">
        <span>Validés aujourd'hui</span>
        <strong id="used-count">—</strong>
    </div>
</div>

<script>
document.getElementById('code-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') verify();
});

document.getElementById('code-input').addEventListener('input', function() {
    var val = this.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    var parts = val.match(/.{1,4}/g) || [];
    this.value = parts.join('-').substring(0, 9);
});

function verify() {
    var code = document.getElementById('code-input').value.trim();
    if (code.length < 9) return;
    var btn = document.getElementById('verify-btn');
    btn.disabled = true;
    btn.textContent = 'Vérification...';

    fetch('verify_ticket.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'code=' + encodeURIComponent(code)
    })
    .then(function(r) { return r.json(); })
    .then(function(res) { showResult(res); btn.disabled = false; btn.textContent = 'Valider le billet'; })
    .catch(function() {
        showResult({ status: 'error', message: 'Erreur réseau' });
        btn.disabled = false; btn.textContent = 'Valider le billet';
    });
}

function showResult(res) {
    var box   = document.getElementById('result-box');
    var icon  = document.getElementById('result-icon');
    var title = document.getElementById('result-title');
    var det   = document.getElementById('result-details');

    box.className = 'result-box';
    det.innerHTML = '';

    if (res.status === 'valid') {
        box.classList.add('valid');
        icon.textContent  = '✅';
        title.textContent = 'BILLET VALIDE';
        var d = res.data;
        var label = d.ticket_type === 'full' ? 'Entrée Toute la Journée' : 'Entrée Journée';
        det.innerHTML =
            row('Nom', d.prenom + ' ' + d.nom) +
            row('Billet', label) +
            row('Quantité', d.quantity + ' personne(s)') +
            row('Email', d.email);
        loadStats();
    } else if (res.status === 'already_used') {
        box.classList.add('already');
        icon.textContent  = '⚠️';
        title.textContent = 'DÉJÀ UTILISÉ';
        var d = res.data;
        det.innerHTML =
            row('Utilisé le', res.used_at) +
            row('Nom', d.prenom + ' ' + d.nom) +
            row('Email', d.email);
    } else if (res.status === 'invalid') {
        box.classList.add('invalid');
        icon.textContent  = '❌';
        title.textContent = 'BILLET INVALIDE';
        det.innerHTML = '<p style="text-align:center;color:rgba(255,255,255,0.6);font-size:13px;margin-top:8px">' + (res.message || 'Code inconnu') + '</p>';
    } else {
        box.classList.add('invalid');
        icon.textContent  = '❌';
        title.textContent = 'ERREUR';
        det.innerHTML = '<p style="text-align:center;color:rgba(255,255,255,0.6);font-size:13px;margin-top:8px">' + (res.message || '') + '</p>';
    }

    document.getElementById('input-box').style.display = 'none';
    box.style.display = 'block';
}

function row(label, value) {
    return '<div class="result-row"><span class="result-label">' + label + '</span><strong>' + (value || '—') + '</strong></div>';
}

function reset() {
    document.getElementById('result-box').style.display = 'none';
    document.getElementById('input-box').style.display = 'block';
    var input = document.getElementById('code-input');
    input.value = '';
    input.focus();
}

function loadStats() {
    fetch('scan_stats.php?json=1')
        .then(function(r) { return r.json(); })
        .then(function(res) {
            document.getElementById('used-count').textContent = res.count ?? '—';
        }).catch(function() {});
}

document.getElementById('code-input').focus();
loadStats();
</script>
<?php endif; ?>
</body>
</html>
