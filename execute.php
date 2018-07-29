<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
    exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatid = isset($message['chat']['id']) ? $message['chat']['id'] : "";
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
    send($chatid, "Scusa ma non ho capito! Puoi provare a ripetere?");
}

function send($chatid, $text){
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}

function sendKeyboard($chatid, $text) {
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    $keyboardStructure = array(array(array("text" => "Needs Guardare", "callback_data" => "needsGuardare"),
        array("text" => "Wants Guardare", "callback_data" => "wantsGuardare"),
        array("text" => "Needs Guardare+Parlare", "callback_data" => "needsGuardareParlare"),
        array("text" => "Wants Guardare+Parlare", "callback_data" => "wantsGuardareParlare"),),);
    $keyboard = ['inline_keyboard' => $keyboardStructure];
    $parameters["reply_markup"] = json_encode($keyboard, true);
}

