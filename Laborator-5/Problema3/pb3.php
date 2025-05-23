<?php
header('Content-Type: application/json');

try {
    $db = new PDO('sqlite:books.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
        $stmt = $db->query('select id from books');
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($ids);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $db->prepare('select * from books where id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($book ?: []);
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("update  books set title = :t, author = :a, year = :y where id = :id");
        $stmt->bindValue(':t', $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(':a', $data['author'], PDO::PARAM_STR);
        $stmt->bindValue(':y', $data['year'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
        $ok = $stmt->execute();
        echo json_encode(["success" => $ok]);
        exit;
    }
    http_response_code(405);
    echo json_encode(["error" => "Metoda nesuportata"]);
} catch (PDOException $error) {
    echo json_encode(["Eroare" => $error->getMessage()]);
};
