<?php
header('Content-Type: application/json');

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina = max($pagina, 1);
$limit = 3;
$offset = ($pagina - 1) * $limit;

try {
    $db = new PDO('sqlite:formularWeb.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtTotal = $db->query("select count(*) from formular");
    $totalRows = (int)$stmtTotal->fetchColumn();
    $totalPages = ceil($totalRows / $limit);

    $stmt = $db->prepare('select * from formular order by id limit :limit offset :offset');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "pagina" => $pagina,
        "total" => $totalPages,
        "date" => $rows
    ]);
} catch (PDOException $error) {
    echo json_encode(["Eroare" => $error->getMessage()]);
}
