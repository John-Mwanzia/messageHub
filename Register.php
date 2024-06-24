<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/register_view.inc.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="form_wrapper">
        <form action="includes/register.inc.php" method="post">
            <h1>Register</h1>
            <label for="username">Username</label>
            <input type="text" name="username" required><br>
            <label for="email">Email</label>
            <input type="email" name="email" required><br>
            <label for="regNo">Registration Number</label>
            <input type="text" name="regNo" required><br>
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" required><br>
            <label for="password">Password</label>
            <input type="password" name="password" required><br>
            <label for="password2">Confirm Password</label>
            <input type="password" name="password2" required><br>
            <p>
                Already have an account? <a class="link" style="color: blue; text-decoration: none;" href="login.php">Login</a>
            </p>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
    <div class="error-message">

        <?php
        check_signup_errors();
        ?>
    </div>
</body>

</html>