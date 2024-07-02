<?php
require_once __DIR__ . '/config_session.inc.php';
require_once 'dbh.inc.php';
require_once __DIR__ . '/dashboard_model.php';

$verified_numbers = ["0719488100", "0759654638", "0757702765"];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $selected_numbers = $_POST['numbers'] ?? [];
    $input_phones = $_POST['phones'];

    // Split input phones by comma and trim whitespace
    $input_phones_array = array_map('trim', explode(',', $input_phones));

    // Validate and add input phones to selected numbers if they are in the verified list
    foreach ($input_phones_array as $phone) {
        if ($phone && in_array($phone, $verified_numbers)) {
            $selected_numbers[] = $phone;
        } else if ($phone) {
            $_SESSION['error_unverified_phones'] = "Invalid number: $phone. Only use the provided numbers.";
            header("Location: ../dashboard.php");
            exit();
        }
    }


    // Format all selected numbers
    $formatted_selected_numbers = array_map('format_phone_number', $selected_numbers);
    // log
    // var_dump($formatted_selected_numbers);

    // Send SMS only to verified numbers
    // loop and pass the formatted numbers to the send_sms function
    foreach ($formatted_selected_numbers as $phone) {
        send_sms($phone, $message);
    }

    $_SESSION['success'] = "Message sent successfully!";
    header("Location: ../dashboard.php");
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
