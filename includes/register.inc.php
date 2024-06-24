<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $regNo = $_POST['regNo'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    try {
        // import the database connection 
        require_once 'dbh.inc.php';
        require_once 'register_model.inc.php';
        require_once 'register_contr.inc.php';


        // Error handlers
        $errors = [];
        // Check for empty fields
        if (is_input_empty($username, $email, $regNo, $phone, $password, $password2)) {
            $errors["empty_input"] = "Please fill in all fields";
        }
        // Check if email is valid  
        if (is_email_valid($email)) {
            $errors["invalid_email"] = "Invalid email address";
        }
        // Check if passwords match
        if (is_password_match($password, $password2)) {
            $errors["password_mismatch"] = "Passwords do not match";
        }
        // Check if username is taken
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username is already taken";
        }
        // Check if email is already registered
        if (is_email_registered($pdo, $email)) {
            $errors["email_registered"] = "Email is already registered";
        }

        // start a session configured on this file config_session.inc.php
        require_once 'config_session.inc.php';


        if ($errors) {
            $_SESSION['signup_errors'] = $errors;
            header("Location: ../Register.php ");
        }

        // If there are no errors, register the user
        create_user($pdo, $username, $email, $regNo, $phone, $password);

        // Redirect to the Token verification page and be able to access the phone number 
        header("Location: ../verify.php?phone=$phone");
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../Register.php ");
    die();
}
