<?php
header('Content-Type: application/json');

$plecare = $_GET['plecare'];
if ($plecare === '') {
    echo json_encode([]);
    exit;
}

try {
    $db = new PDO('sqlite:rute.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare('select sosire from rute where plecare = :plecare');
    $stmt->bindValue(':plecare', $plecare, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($rows);
} catch (PDOException $erorr) {
    echo json_encode(["Eroare: " . $erorr->getMessage()]);
}
