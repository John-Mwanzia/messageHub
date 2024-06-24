<?php
function verify_token(object $pdo, string $token): bool
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        return true;
    } else {
        return false;
    }
}