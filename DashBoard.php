<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: register.php");
    exit();
}

if (!$user['is_verified']) {
    header("Location: verify.php?phone=" . urlencode($user['phone']));
    exit();
}

// Predefined verified numbers
$verified_numbers = ["0719488100"];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <div class="dashboard-wrapper" style=" width: 70vw; padding: 5rem">
        <nav class="header">
            <h1>
                SmsHub
            </h1>
        </nav>

        <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- success message -->
        <?php
        if (isset($_SESSION['success'])) {

            echo "<div class='success-wrapper'>";
            echo "<div class='success-bar'></div>";
            echo "<div class='succesMessage' >" . $_SESSION['success'] . "</div>";
            echo "</div>";
            unset($_SESSION['success']);
        }
        ?>

        <div class="form_wrapper">
            <form action="includes/dashboard.inc.php" method="post" style="width: 100% ">
                <h3>Send Bulk SMS</h3>
                <input placeholder="Enter phone number" type="text" name="phone" style="width: auto;">
                <?php
                if (isset($_SESSION['error_unverified_phones'])) {
                    echo "<p class='error-message'>" . $_SESSION['error_unverified_phones'] . "</p>";
                    unset($_SESSION['error_unverified_phones']);
                }
                ?>
                <p>
                    or select from the list below
                </p>

                <?php foreach ($verified_numbers as $number) : ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="numbers[]" value="<?php echo $number; ?>">
                            <?php echo $number; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
                <label for="message" style="margin-top: 1rem;">Message</label>
                <textarea name="message" style="width: 100%; margin-bottom: 2rem; height: 10rem" required></textarea>
                <button type="submit" style="width: auto;">Send Message</button>
            </form>
        </div>
    </div>
</body>

</html>