<?php

namespace Repo;

use PDO;

final class ProdusRepo
{
    public static function paginare(PDO $pdo, int $page, int $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare('select * from produse limit :lim offset :offset');

        $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        $total = (int)$pdo->query('select count(*) from produse')->fetchColumn();

        return array($rows, $total);
    }
}
