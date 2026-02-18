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

    file_get_contents($apiURL . "sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($message));
}
