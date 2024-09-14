<?php
require 'db.php';

function register($login, $password, $role = 'user'): bool
{
    global $pdo;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO users (login, password, role) VALUES (?, ?, ?)');
    return $stmt->execute([$login, $passwordHash, $role]);
}

function login($login, $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }

    logFailedAttempt($login);
    return false;
}

function vkLogin($vk_id): true
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE vk_id = ?');
    $stmt->execute([$vk_id]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user;
        return true;
    }

    $stmt = $pdo->prepare('INSERT INTO users (login, vk_id, role) VALUES (?, ?, ?)');
    $login = 'vk_user_' . $vk_id;
    $stmt->execute([$login, $vk_id, 'vk_user']);
    $_SESSION['user'] = [
        'login' => $login,
        'role' => 'vk_user'
    ];

    return true;
}

function logout(): void
{
    session_destroy();
}

function logFailedAttempt($login): void
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO auth_logs (login, success) VALUES (?, ?)');
    $stmt->execute([$login, false]);
}

function isVkUser(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'vk_user';
}
