<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="form_wrapper">
        <form action="includes/login.inc.php" method="post">
            <h1>Login</h1>
            <label for="username">Username</label>
            <input type="text" name="username" required><br>
            <label for="password">Password</label>
            <input type="password" name="password" required><br>
            <p>
                Don't have an account? <a href="Register.php" style="color: blue; text-decoration: none;">Register</a>
            </p>
            <button type="submit" name="login">Login</button>
        </form>

    </div>
    <div class="error-message">


        <?php
        display_login_errors();
        ?>
    </div>
</body>

</html>