<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';

session_set_cookie_params(['httponly' => true, 'samesite' => 'Strict', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();

$action = $_GET['action'] ?? '';

// ---------- Login / logout ----------
if ($action === 'logout') {
    session_destroy();
    header('Location: ./');
    exit;
}

$loginError = '';
if (empty($_SESSION['admin']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    usleep(300000); // slow down brute force
    if (hash_equals($config['admin_user'], (string) $_POST['user']) && hash_equals($config['admin_pass'], (string) $_POST['pass'])
        && $config['admin_pass'] !== 'change-this-password') {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
        header('Location: ./');
        exit;
    }
    $loginError = $config['admin_pass'] === 'change-this-password'
        ? 'Set admin_pass in config.php first.'
        : 'Wrong username or password.';
}

if (empty($_SESSION['admin'])): ?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Guest2Kart Admin Login</title><meta name="robots" content="noindex" /><script src="https://cdn.tailwindcss.com"></script></head>
<body class="grid min-h-screen place-items-center bg-slate-100 p-4">
  <form method="post" class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-xl">
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Guest<span class="text-indigo-600">2</span>Kart Admin</h1>
    <?php if ($loginError): ?><p class="mb-4 rounded bg-red-50 p-3 text-sm text-red-600"><?= e($loginError) ?></p><?php endif; ?>
    <input name="user" placeholder="Username" required class="mb-3 w-full rounded-lg border px-3 py-2.5" />
    <input name="pass" type="password" placeholder="Password" required class="mb-5 w-full rounded-lg border px-3 py-2.5" />
    <button name="login" value="1" class="w-full rounded-lg bg-indigo-600 py-2.5 font-semibold text-white hover:bg-indigo-700">Login</button>
  </form>
</body></html>
<?php exit; endif;

// ---------- Logged-in actions ----------
const STATUSES = ['new', 'contacted', 'converted', 'closed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Invalid request');
    }
    $id = (int) ($_POST['id'] ?? 0);
    if (isset($_POST['delete'])) {
        db()->prepare('DELETE FROM leads WHERE id = ?')->execute([$id]);
    } else {
        $status = in_array($_POST['status'] ?? '', STATUSES, true) ? $_POST['status'] : 'new';
        db()->prepare('UPDATE leads SET status = ?, note = ? WHERE id = ?')
            ->execute([$status, clip($_POST['note'] ?? '', 2000), $id]);
    }
    header('Location: ./?' . http_build_query(array_intersect_key($_GET, ['q' => 1, 'status' => 1])));
    exit;
}

if ($action === 'csv') {
    $cols = ['created_at', 'name', 'email', 'phone', 'website', 'service', 'budget', 'message', 'status', 'note'];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="guest2kart-leads.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, $cols);
    foreach (db()->query('SELECT ' . implode(',', $cols) . ' FROM leads ORDER BY id DESC') as $row) {
        // prevent CSV formula injection in Excel
        fputcsv($out, array_map(fn($v) => preg_match('/^[=+\-@]/', (string) $v) ? "'" . $v : $v, $row));
    }
    exit;
}

$q = trim((string) ($_GET['q'] ?? ''));
$filter = in_array($_GET['status'] ?? '', STATUSES, true) ? $_GET['status'] : '';

$sql = 'SELECT * FROM leads WHERE 1=1';
$params = [];
if ($q !== '') {
    $sql .= ' AND (name LIKE :q OR email LIKE :q OR website LIKE :q OR phone LIKE :q)';
    $params['q'] = "%$q%";
}
if ($filter !== '') {
    $sql .= ' AND status = :status';
    $params['status'] = $filter;
}
$stmt = db()->prepare($sql . ' ORDER BY id DESC');
$stmt->execute($params);
$leads = $stmt->fetchAll();

$counts = ['total' => 0] + array_fill_keys(STATUSES, 0);
foreach (db()->query('SELECT status, COUNT(*) c FROM leads GROUP BY status') as $r) {
    $counts[$r['status']] = (int) $r['c'];
    $counts['total'] += (int) $r['c'];
}
$csrf = e($_SESSION['csrf']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Guest2Kart Admin – Leads</title><meta name="robots" content="noindex" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
  <header class="flex flex-wrap items-center justify-between gap-3 bg-slate-900 px-6 py-4 text-white">
    <h1 class="text-xl font-bold">Guest2Kart Admin</h1>
    <nav class="flex flex-wrap gap-2 text-sm">
      <a href="./" class="rounded-lg bg-slate-700 px-4 py-2">📥 Leads</a>
      <a href="content.php" class="rounded-lg px-4 py-2 hover:bg-slate-700">✏️ Website Content</a>
      <a href="../" target="_blank" class="rounded-lg px-4 py-2 hover:bg-slate-700">🌐 View Site</a>
      <a href="?action=csv" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold hover:bg-indigo-500">⬇ Export CSV</a>
      <a href="?action=logout" class="rounded-lg px-4 py-2 hover:bg-slate-700">Logout</a>
    </nav>
  </header>

  <main class="mx-auto max-w-7xl p-6">
    <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-5">
      <?php foreach ($counts as $k => $v): ?>
        <div class="rounded-xl bg-white p-4"><b class="block text-2xl"><?= $v ?></b><span class="text-sm capitalize text-slate-500"><?= $k ?></span></div>
      <?php endforeach; ?>
    </div>

    <form class="mb-4 flex flex-wrap gap-2">
      <input name="q" value="<?= e($q) ?>" placeholder="Search name, email, website..." class="min-w-[220px] flex-1 rounded-lg border px-3 py-2" />
      <select name="status" class="rounded-lg border px-3 py-2">
        <option value="">All status</option>
        <?php foreach (STATUSES as $s): ?><option <?= $s === $filter ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?>
      </select>
      <button class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white">Filter</button>
    </form>

    <div class="overflow-x-auto rounded-xl bg-white">
      <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr><?php foreach (['Date', 'Name / Email', 'Phone', 'Website', 'Service', 'Budget', 'Message', 'Mail', 'Status & Note', ''] as $h): ?><th class="p-3"><?= $h ?></th><?php endforeach; ?></tr>
        </thead>
        <tbody>
        <?php if (!$leads): ?>
          <tr><td colspan="10" class="p-10 text-center text-slate-500">No leads yet.</td></tr>
        <?php endif; foreach ($leads as $l): ?>
          <tr class="border-t align-top">
            <td class="whitespace-nowrap p-3"><?= e(date('d M Y, H:i', strtotime($l['created_at'] . ' UTC'))) ?></td>
            <td class="p-3"><b><?= e($l['name']) ?></b><br /><a class="text-indigo-600" href="mailto:<?= e($l['email']) ?>"><?= e($l['email']) ?></a></td>
            <td class="p-3"><?= e($l['phone']) ?></td>
            <td class="max-w-[160px] break-words p-3"><?= e($l['website']) ?></td>
            <td class="p-3"><span class="rounded-full bg-indigo-50 px-2 py-0.5 text-xs text-indigo-700"><?= e($l['service']) ?></span></td>
            <td class="p-3"><?= e($l['budget']) ?></td>
            <td class="max-w-xs whitespace-pre-wrap p-3"><?= e($l['message']) ?></td>
            <td class="p-3"><?= $l['email_sent'] ? '✅' : '❌' ?></td>
            <td class="p-3">
              <form method="post" class="flex flex-col gap-1.5">
                <input type="hidden" name="csrf" value="<?= $csrf ?>" /><input type="hidden" name="id" value="<?= (int) $l['id'] ?>" />
                <select name="status" class="rounded border px-2 py-1">
                  <?php foreach (STATUSES as $s): ?><option <?= $s === $l['status'] ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?>
                </select>
                <textarea name="note" rows="2" placeholder="Note" class="w-44 rounded border px-2 py-1"><?= e($l['note']) ?></textarea>
                <button class="rounded bg-slate-800 px-2 py-1 text-xs text-white">Save</button>
              </form>
            </td>
            <td class="p-3">
              <form method="post" onsubmit="return confirm('Delete this lead?')">
                <input type="hidden" name="csrf" value="<?= $csrf ?>" /><input type="hidden" name="id" value="<?= (int) $l['id'] ?>" />
                <button name="delete" value="1" class="rounded bg-red-500 px-3 py-1 text-xs text-white">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
