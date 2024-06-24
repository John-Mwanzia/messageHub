<?php

declare(strict_types=1);

function is_input_empty(string $username, string $password): bool {
    return empty($username) || empty($password);
}

function login_user(object $pdo, string $username, string $password): bool {
    $user = get_user_by_username($pdo, $username);
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_verified'] = $user['is_verified'];
        return true;
    } else {
        return false;
    }
}
