<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$board = $data['board'];
$userSymbol = $data['symbol'];
$pcSymbol = $userSymbol === 'X' ? 'O' : 'X';

function checkWinner(array $b, string $s): bool
{
    $posibilities = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];
    foreach ($posibilities as $p) {
        if ($b[$p[0]] === $s && $b[$p[1]] === $s && $b[$p[2]] === $s) {
            return true;
        }
    }
    return false;
}
function isDraw(array $b): bool
{
    return !in_array('', $b, true);
}

if (checkWinner($board, $userSymbol)) {
    $status = 'win';
    $winner = 'user';
} else {
    $moved = false;
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === '') {
            $board[$i] = $pcSymbol;
            $moved = true;
            break;
        }
    }
    if (checkWinner($board, $pcSymbol)) {
        $status = 'win';
        $winner = 'pc';
    } elseif (isDraw($board)) {
        $status = 'draw';
        $winner = null;
    } else {
        $status = 'continue';
        $winner = null;
    }
}

try {
    $db = new PDO('sqlite:game.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("
        insert into games(tabla, tur_current, status_curent, castigator) values (:t, :tc, :sc, :c)
    ");
    $stmt->bindValue(':t', json_encode($board), PDO::PARAM_STR);
    $stmt->bindValue(':tc', $status === 'continue' ? 'user' : null, PDO::PARAM_STR);
    $stmt->bindValue(':sc', $status, PDO::PARAM_STR);
    $stmt->bindValue(':c', $winner, PDO::PARAM_STR);
    $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
echo json_encode([
    'board'  => $board,
    'status' => $status,
    'winner' => $winner
]);
