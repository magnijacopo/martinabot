<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
    exit;
}

function callback($update){
    return $update["callback_query"];
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

$callbackid = $update["callback_query"]["from"]["id"];
$callbackdata = $update["callback_query"]["data"];




$needs_par = false;
$needs_parguar = false;
$wants_par = false;
$wants_parguar = false;

if(strpos($text, "/start") === 0 ) {
    sendKeyboard($chatid, "Benvenuto, sono la tua commessa personale! \n 
    Scegli che questionario farà la prossima persona!");
} else {
    send($chatid, "Purtroppo non ho capito cosa mi hai chiesto! Puoi provare a ripetere?");
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
    $keyboard = ['inline_keyboard' => [[["text" => "Needs Parlare", "callback_data" => "needsParlare"],
    ["text" => "Wants Parlare", "callback_data" => "wantsParlare"]]]];
    $parameters["reply_markup"] = json_encode($keyboard, true);
    echo json_encode($parameters);
}

/* header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $text);
$parameters["method"] = "sendMessage";
$keyboard = ['inline_keyboard' => $keyboardStructure];
$keyboardStructure = array(array(array("text" => "Needs Parlare", "callback_data" => "needsParlare"),
    array("text" => "Wants Parlare", "callback_data" => "wantsParlare"),
    array("text" => "Needs Guardare+Parlare", "callback_data" => "needsGuardareParlare"),
    array("text" => "Wants Guardare+Parlare", "callback_data" => "wantsGuardareParlare"),),);

$parameters["reply_markup"] = json_encode($keyboard, true);
echo json_encode($parameters);
*/

if(callback($update)){
    if(strpos($callbackdata , "needsParlare") === 0){
        $needs_par = true;
        send($chatid, "Hai scelto needsParlare, infatti needs par = ".$needs_par);
    } elseif ($callbackdata == "wantsParlare") {
        $wants_par = true;
        send($callbackid, "Hai scelto wantsParlare, infatti needs par = ".$wants_par);
    } elseif ($callbackdata == "needsGuardareParlare") {
        $needs_parguar = true;
        send($callbackid, "Hai scelto needsGuardareParlare, infatti needs par = ".$needs_parguar);
    } elseif ($callbackdata == "wantsGuardareParlare") {
        $wants_parguar = true;
        send($callbackid, "Hai scelto wantsGuardareParlare, infatti needs par = ".$wants_parguar);
    }
}