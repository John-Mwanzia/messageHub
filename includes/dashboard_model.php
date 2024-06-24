<?php

declare(strict_types=1);

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

require_once "../vendor/autoload.php";

function send_sms(array $phones, string $message): void
{
    $api_url = $_ENV['API_URL'];
    $api_key = $_ENV['API_KEY'];
    $configuration = new Configuration(host: $api_url, apiKey: $api_key);
    $smsApi = new SmsApi(config: $configuration);

    foreach ($phones as $phone) {
        $destination = new SmsDestination(to: $phone);
        $message = new SmsTextualMessage(
            destinations: [$destination],
            text: $message,
            from: "SmsHub",
        );

        try {
            $request = new SmsAdvancedTextualRequest(messages: [$message]);
            $response = $smsApi->sendSmsMessage($request);
        } catch (ApiException $e) {
            echo "Failed to send message: $e \n";
        }
    }
}
