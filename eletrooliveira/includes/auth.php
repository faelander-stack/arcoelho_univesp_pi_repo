<?php
require_once __DIR__ . '/functions.php';

function login_user(string $email, string $password): bool
{
    $stmt = db()->prepare('SELECT * FROM fv_users WHERE email = :email AND is_active = 1 LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];

    return true;
}

function logout_user(): void
{
    unset($_SESSION['user']);
    session_regenerate_id(true);
}
