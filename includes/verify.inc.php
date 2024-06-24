<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];

    try {
        require_once 'dbh.inc.php';
        require_once 'verify_model.inc.php';

        if (verify_token($pdo, $token)) {
            header("Location: ../login.php");
            exit();
        } else {
            header("Location: ../verify.php?error=invalid_token");
            exit();
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../verify.php");
    die();
}


