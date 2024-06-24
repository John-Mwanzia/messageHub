<?php
require_once 'config_session.inc.php';

function display_login_errors(): void {
    if (isset($_SESSION['login_errors'])) {
        $errors = $_SESSION['login_errors'];
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        // Unset the session variable
        unset($_SESSION['login_errors']);
    }
}
