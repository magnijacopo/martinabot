<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
    exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

$needs_par = false;
$needs_parguar = false;
$wants_par = false;
$wants_parguar = false;

if(strpos($text, "/start") === 0 )
{
    send($chatid, "Benvenuto, sono la tua commessa personale!");

} else {
    $response = trim($text);
}

function send($chatid, $text){
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $response);

$parameters["method"] = "sendMessage";
echo json_encode($parameters);

