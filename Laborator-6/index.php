<?php


require_once "Init/config.php";
require_once "Repo/ProdusRepo.php";
require_once "Security/CSRF.php";
require_once "Security/Input.php";



$allowedN = [5, 10, 25, 50];
$n = Security\Input::isInList('n', $allowedN, 10);
try {
    $page = Security\Input::intRange('page', 1, 10_000, 1);
} catch (InvalidArgumentException $e) {
    header('Location: ?page=1', true, 302);
    exit;
}
Security\Csrf::check($_GET['csrf'] ?? null);

[$rows, $total] = Repo\ProdusRepo::paginare($pdo, $page, $n);
$pages = max((int)ceil($total / $n), 1);
$base  = '?n=' . $n . '&csrf=' . Security\Csrf::token() . '&';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 2</title>
</head>

<body>
    <h1>Produse</h1>
    <form method="get">
        <label>Pe pagina:</label>
        <select name="n">
            <?php foreach ($allowedN as $opt): ?>
                <option value="<?= $opt ?>" <?= $opt === $n ? 'selected' : ''; ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="csrf" value="<?= e(Security\Csrf::token()) ?>">
        <button>Show</button>
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
    <nav class="pager">
        <a class="btn prev <?= $page <= 1 ? 'off' : '' ?>"
            href="<?= e($base . 'page=' . ($page - 1)) ?>">Previous</a>

        <span class="status">Pagina <?= $page ?> / <?= $pages ?></span>

        <a class="btn next <?= $page >= $pages ? 'off' : '' ?>"
            href="<?= e($base . 'page=' . ($page + 1)) ?>">Next</a>
    </nav>
</body>

</html>