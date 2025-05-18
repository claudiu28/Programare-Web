<?php

namespace Security;

final class Csrf
{
    public static function token()
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function check(?string $token): void
    {
        if (!hash_equals($_SESSION['csrf'] ?? '', (string)$token)) {
            http_response_code(403);
            exit('CSRF invalid.');
        }
    }
}
