<?php

declare(strict_types=1);

session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: default-src 'self'");
function e(string|int|float|null $val): string
{
    return htmlspecialchars((string)$val, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$pdo = new PDO('sqlite:' . __DIR__ . '/produse.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$allowedN = [5, 10, 25, 50];
$n = (int)($_GET['n']   ?? 10);
$n = in_array($n, $allowedN, true) ? $n : 10;

$page = (int)($_GET['page'] ?? 1);
$page = $page >= 1 ? $page : 1;

$offset = ($page - 1) * $n;
$stmt = $pdo->prepare('select * from produse order by id limit :lim offset :off');
$stmt->bindValue(':lim', $n,  PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();
$total = (int)$pdo->query('select count(*) from produse')->fetchColumn();
$pages = max(1, (int)ceil($total / $n));
if ($page > $pages) {
    header('Location: ?n=' . $n . '&page=1', true, 302);
    exit;
}
$base = '?n=' . $n . '&';
$prevPage = max(1, $page - 1);
$nextPage = min($pages, $page + 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Produse</title>
</head>

<body>
    <h1>Produse</h1>
    <form method="get">
        <label>N = </label>
        <select name="n">
            <?php foreach ($allowedN as $opt): ?>
                <option value="<?= $opt ?>" <?= $opt === $n ? 'selected' : '' ?>>
                    <?= $opt ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="page" value="1">
        <button>Switch</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Denumire</th>
                <th>Pret</th>
                <th>Descriere</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['id']) ?></td>
                    <td><?= e($r['denumire']) ?></td>
                    <td><?= number_format((float)$r['pret'], 2, ',', '.') ?></td>
                    <td><?= e($r['descriere']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <nav>
        <a href="<?= e($base . 'page=' . $prevPage) ?>">Previous</a>
        <span>Pagina <?= $page ?> / <?= $pages ?></span>
        <a href="<?= e($base . 'page=' . $nextPage) ?>">Next</a>
    </nav>
</body>

</html>