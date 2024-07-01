<?php

declare(strict_types=1);

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

require_once "../vendor/autoload.php";
// require_once 'HTTP/Request2.php';
// require __DIR__ . "../vendor/autoload.php";


function get_username(object $pdo, string $username): bool
{
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return true;
    } else {
        return false;
    }
}

function get_email(object $pdo, string $email): bool
{
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo, string $username, string $email, string $regNo, string $phone, string $password): void
{
    $options = [
        'cost' => 12,
    ];
    $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
    $token = bin2hex(random_bytes(3)); // Shorter token for SMS
    $query = "INSERT INTO users (username, email, password_hash, token, registration_number, phone_number) VALUES (:username, :email, :password_hash, :token, :registration_number, :phone_number)";
    $stmt = $pdo->prepare($query);
    $user =  $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password_hash' => $password_hash,
        'token' => $token,
        'registration_number' => $regNo,
        'phone_number' => $phone
    ]);

    // Send verification SMS with the token
    send_verification_sms($phone, $token);
}

// with twilio
// function send_verification_sms(string $phone, string $token): void
// {
//     $formated_phone = format_phone_number($phone);
//     $account_sid = getenv('TWILIO_ACCOUNT_SID');
//     $auth_token = getenv('TWILIO_AUTH_TOKEN');
//     $twilio_number = getenv('TWILIO_NUMBER');

//     $client = new \Twilio\Rest\Client($account_sid, $auth_token);
//     $client->messages->create(
//         "+2540707979247",
//         [
//             'from' => $twilio_number,
//             'body' => "Your verification code is: $token"
//         ]
//     );
// }
// with infobip
function send_verification_sms(string $phone, string $token): void
{
    $formated_phone = format_phone_number($phone);
    // $formated_phone = "254719488100";

    $api_url = $_ENV['API_URL'];
    $api_key = $_ENV['API_KEY'];
    $configuration = new Configuration(host: $api_url, apiKey: $api_key);
    $smsApi = new SmsApi(config: $configuration);

    $destination = new SmsDestination(to: $formated_phone);
    $message = new SmsTextualMessage(
        destinations: [$destination],
        text: "Your verification code is: $token",
        from: "SmsHub",
    );

    try {
        $request = new SmsAdvancedTextualRequest(messages: [$message]);
        $response = $smsApi->sendSmsMessage($request);
        echo "Message sent successfully! \n";
    } catch (ApiException $e) {
        echo "Failed to send message: $e \n";
    }
}






function format_phone_number(string $phone): string
{
    // Remove all non-numeric characters
    $phone = preg_replace('/\D/', '', $phone);

    // Remove leading zeroes
    $phone = ltrim($phone, '0');

    // Prepend the country code if not present
    if (strpos($phone, '254') !== 0) {
        $phone = '254' . $phone;
    }

    return $phone;
}
