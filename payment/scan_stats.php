<?php
require_once '../config.php';

// Appelé en AJAX depuis scan.php → retourner JSON
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_GET['json'])) {
    header('Content-Type: application/json');
    if (empty($_SESSION['scan_auth'])) { echo json_encode(['count' => 0]); exit; }
    $db_path = __DIR__ . '/../logs/tickets.db';
    if (!file_exists($db_path)) { echo json_encode(['count' => 0]); exit; }
    $db    = new PDO('sqlite:' . $db_path);
    $today = date('Y-m-d');
    $stmt  = $db->prepare("SELECT COUNT(*) FROM tickets WHERE used_at LIKE ?");
    $stmt->execute(["$today%"]);
    echo json_encode(['count' => (int)$stmt->fetchColumn()]); exit;
}

// Page HTML
if (empty($_SESSION['scan_auth'])) {
    header('Location: scan.php'); exit;
}

$db_path = __DIR__ . '/../logs/tickets.db';
$scans   = [];
$total   = 0;
$today   = date('Y-m-d');
$today_count = 0;

if (file_exists($db_path)) {
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt  = $db->query("SELECT * FROM tickets WHERE used_at IS NOT NULL ORDER BY used_at DESC");
    $scans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = count($scans);
    foreach ($scans as $s) {
        if (str_starts_with($s['used_at'] ?? '', $today)) $today_count++;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de scan — Coco Italia Beach</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:sans-serif; background:#1a0f08; color:#fff; min-height:100vh; padding:24px 16px; }
        .wrap { max-width:900px; margin:0 auto; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:12px; }
        .header h1 { font-size:20px; }
        .back-btn { background:rgba(255,255,255,0.1); border:none; color:#fff; padding:9px 16px; border-radius:8px; font-size:13px; cursor:pointer; text-decoration:none; }
        .back-btn:hover { background:rgba(255,255,255,0.18); }

        .kpis { display:flex; gap:12px; margin-bottom:28px; flex-wrap:wrap; }
        .kpi { flex:1; min-width:130px; background:#2a1a0e; border-radius:12px; padding:18px 20px; text-align:center; }
        .kpi-val { font-size:36px; font-weight:900; color:#F47C20; }
        .kpi-label { font-size:12px; color:rgba(255,255,255,0.5); margin-top:4px; }

        .search-bar { margin-bottom:16px; }
        .search-bar input { width:100%; padding:11px 16px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; font-size:14px; }
        .search-bar input::placeholder { color:rgba(255,255,255,0.3); }

        table { width:100%; border-collapse:collapse; font-size:13px; }
        thead th { background:#2a1a0e; padding:12px 14px; text-align:left; color:rgba(255,255,255,0.5); font-weight:600; font-size:11px; text-transform:uppercase; letter-spacing:.5px; }
        thead th:first-child { border-radius:8px 0 0 0; }
        thead th:last-child  { border-radius:0 8px 0 0; }
        tbody tr { border-bottom:1px solid rgba(255,255,255,0.05); }
        tbody tr:hover { background:rgba(255,255,255,0.04); }
        tbody td { padding:11px 14px; color:rgba(255,255,255,0.85); }
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-full { background:#78350f; color:#fbbf24; }
        .badge-jour { background:#1e3a5f; color:#60a5fa; }
        .empty { text-align:center; padding:40px; color:rgba(255,255,255,0.3); }
        .today-row td { background:rgba(244,124,32,0.07); }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>📊 Statistiques de scan</h1>
        <a href="scan.php" class="back-btn">← Retour au scanner</a>
    </div>

    <div class="kpis">
        <div class="kpi">
            <div class="kpi-val"><?= $today_count ?></div>
            <div class="kpi-label">Scannés aujourd'hui</div>
        </div>
        <div class="kpi">
            <div class="kpi-val"><?= $total ?></div>
            <div class="kpi-label">Total scannés</div>
        </div>
        <div class="kpi">
            <div class="kpi-val"><?= count(array_filter($scans, fn($s) => ($s['ticket_type'] ?? '') === 'full')) ?></div>
            <div class="kpi-label">Full Day validés</div>
        </div>
        <div class="kpi">
            <div class="kpi-val"><?= count(array_filter($scans, fn($s) => ($s['ticket_type'] ?? '') === 'journee')) ?></div>
            <div class="kpi-label">Journée validés</div>
        </div>
    </div>

    <div class="search-bar">
        <input type="text" id="search" placeholder="Rechercher par session ID, email..." oninput="filterTable()">
    </div>

    <?php if (empty($scans)): ?>
        <div class="empty">Aucun billet scanné pour l'instant.</div>
    <?php else: ?>
    <table id="scan-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Type</th>
                <th>Qté</th>
                <th>Validé le</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($scans as $i => $s):
            $is_today = str_starts_with($s['used_at'] ?? '', $today);
            $type     = $s['ticket_type'] ?? '';
            $label    = $type === 'full' ? 'Full Day' : 'Journée';
            $badge    = $type === 'full' ? 'badge-full' : 'badge-jour';
        ?>
            <tr class="<?= $is_today ? 'today-row' : '' ?>">
                <td style="color:rgba(255,255,255,0.3)"><?= $total - $i ?></td>
                <td style="font-family:monospace;font-size:13px;letter-spacing:2px"><?= htmlspecialchars($s['code'] ?? '—') ?></td>
                <td><?= htmlspecialchars(($s['prenom'] ?? '') . ' ' . ($s['nom'] ?? '')) ?></td>
                <td><?= htmlspecialchars($s['email'] ?? '—') ?></td>
                <td><span class="badge <?= $badge ?>"><?= $label ?></span></td>
                <td><?= htmlspecialchars($s['quantity'] ?? '—') ?></td>
                <td><?= htmlspecialchars($s['used_at'] ?? '—') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<script>
function filterTable() {
    var q = document.getElementById('search').value.toLowerCase();
    var rows = document.querySelectorAll('#scan-table tbody tr');
    rows.forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
</body>
</html>
