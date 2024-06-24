<?php
require_once __DIR__ . '/config_session.inc.php';
require_once 'dbh.inc.php';
require_once __DIR__ . '/dashboard_model.php';

$verified_numbers = ["0719488100"];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $selected_numbers = $_POST['numbers'] ?? [];
    $input_phone = $_POST['phone'];


    // Add formatted input phone to selected numbers if it is in the verified list
    if ($input_phone && in_array($input_phone, $verified_numbers)) {
        $selected_numbers[] = $input_phone;
    } else if ($input_phone) {
        $_SESSION['error_unverified_phones'] = "Invalid number: $input_phone. Only use the provided numbers.";
        header("Location: ../dashboard.php");
        exit();
    }


    // Format all selected numbers
    $formatted_selected_numbers = array_map('format_phone_number', $selected_numbers);

    // Send SMS only to verified numbers
    send_sms($formatted_selected_numbers, $message);



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
