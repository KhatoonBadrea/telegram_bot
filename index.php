<?php

$token = getenv("TELEGRAM_TOKEN");
$apiURL = "https://api.telegram.org/bot$token/";

$update = json_decode(file_get_contents("php://input"), true);

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = $update["message"]["text"];

    if ($text == "/start") {
        sendMessage($chat_id, "Hello Khatoon 🤍");
    } else {
        sendMessage($chat_id, "You said: " . $text);
    }
}
function sendMessage($chat_id, $message)
{
    global $apiURL;

    $ch = curl_init($apiURL . "sendMessage");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'chat_id' => $chat_id,
        'text'    => $message,
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log("Telegram API error: " . curl_error($ch));
    }

    curl_close($ch);

    return $response;
}
