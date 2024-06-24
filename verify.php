<?php

declare(strict_types=1);

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

require_once "vendor/autoload.php";
require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';



// if user didn't receive the token
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend'])) {
//     require_once 'includes/dbh.inc.php';
//     require_once 'includes/verify_model.inc.php';

//     // $user_id = $_SESSION['user_id'];
//     $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
//     $stmt->execute([$user_id]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);

 
//     if ($user) {
//         send_verification_sms($user['phone_number'], $user['token']);
//     }
//     unset($_POST['resend']);
// }

// function send_verification_sms(string $phone, string $token): void
// {
//     // $formated_phone = format_phone_number($phone);
//     $formated_phone = "254719488100";

//     $api_url = $_ENV['API_URL'];
//     $api_key = $_ENV['API_KEY'];
//     $configuration = new Configuration(host: $api_url, apiKey: $api_key);
//     $smsApi = new SmsApi(config: $configuration);

//     $destination = new SmsDestination(to: $formated_phone);
//     $message = new SmsTextualMessage(
//         destinations: [$destination],
//         text: "Your verification code is: $token",
//         from: "SmsHub",
//     );

//     try {
//         $request = new SmsAdvancedTextualRequest(messages: [$message]);
//         $response = $smsApi->sendSmsMessage($request);
//         echo "Message sent successfully! \n";
//     } catch (ApiException $e) {
//         echo "Failed to send message: $e \n";
//     }
// }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Verify Account</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>
    <nav class="header">
        <h1>
            SmsHub
        </h1>
    </nav>
    <div class="form_wrapper">
        <form action="includes/verify.inc.php" method="post">
            <h3>Verify Account</h3>
            <?php
            if (isset($_GET['phone'])) {
                $phone = htmlspecialchars($_GET['phone']);
                echo "<p>Enter the token sent to phone number ending with: **" . substr($phone, -3) . "</p>";
            }
            if (isset($_GET['error']) && $_GET['error'] == 'invalid_token') {
                echo "<p class='error-message'>Invalid token. Please try again.</p>";
            }
            ?>
            Token: <input type="text" name="token" required><br>
            <button type="submit">Verify</button>
        </form>
        <form action="" method="post">
            <p>
                Didn't receive the token? Click the button below to resend.
            </p>
            <input type="hidden" name="resend" value="1">
            <button type="submit">Resend Verification Token</button>
        </form>
    </div>
</body>

</html>