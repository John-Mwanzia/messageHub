<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Import the database connection
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        require_once 'config_session.inc.php';

        // Error handlers
        $errors = [];

        // Check for empty fields
        if (is_input_empty($username, $password)) {
            $errors['empty_input'] = "Please fill in all fields";
        }

        // Attempt to login user
        if (empty($errors) && !login_user($pdo, $username, $password)) {
            $errors['invalid_credentials'] = "Invalid username or password";
        }

        if ($errors) {
            $_SESSION['login_errors'] = $errors;
            header("Location: ../login.php");
            exit();
        }

        header("Location: ../dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    die();
}
