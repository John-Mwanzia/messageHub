<?php

declare(strict_types=1);

function get_user_by_username(object $pdo, string $username): ?array {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user ?: null;
}
