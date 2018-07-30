<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update) {
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

$callbackid = $update["callback_query"]["from"]["id"];
$callbackdata = $update["callback_query"]["data"];

/*
1 = Needs Parlare
2 = Needs Parlare e Guardare
3 = Wants Parlare
4 = Wants Parlare e Guardare");
*/
$tipo_questionario = 0;

if($tipo_questionario == 0) {
    //Inizia la conversazione
    if(strpos($text, "/start") === 0 ) {
        send($chatid, "Benvenuto, sono la tua commessa personale! 
    \nScegli che questionario farà la prossima persona!
    \nRicordati:
    \n1 = Needs Parlare
    \n2 = Needs Parlare e Guardare
    \n3 = Wants Parlare
    \n4 = Wants Parlare e Guardare
    \nQuando hai finito un questionario per favore scrivi /stop");
    }
    //Setta il tipo di questionario
    if(strpos($text, "1") === 0) {
        $tipo_questionario = 1;
        send($chatid, "Hai scelto Needs Parlare, inizio subito a chiedere aiuto al cliente!");
    } elseif(strpos($text, "2") === 0) {
        $tipo_questionario = 2;
        send($chatid, "Hai scelto Needs Parlare e Guardare, osservo un po' il cliente e poi gli parlerò");
    } elseif(strpos($text, "3") === 0) {
        $tipo_questionario = 3;
        send($chatid, "Hai scelto Wants Parlare, inizio subito a chiedere aiuto al cliente!");
    } elseif(strpos($text, "4") === 0) {
        $tipo_questionario = 4;
        send($chatid, "Hai scelto Wants Parlare e Guardare, osservo un po' il cliente e poi gli parlerò");
    }
}

if ($tipo_questionario != 0) {

    if(strpos($text, "/stop") === 0 ){
        send($chatid, "Ok, cancello tutto. Scrivi /start per iniziare un nuovo questionario");
        $tipo_questionario = 0;
    } else {
        send($chatid, "Hei, aspetta, sto ancora sviluppando queste funzionalità!!");
    }
}


function send($chatid, $text){
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}







/*

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $text);
$parameters["method"] = "sendMessage";
$keyboard = ['inline_keyboard' => $keyboardStructure];
$keyboardStructure = array(array(array("text" => "Needs Parlare", "callback_data" => "needsParlare"),
    array("text" => "Wants Parlare", "callback_data" => "wantsParlare"),
    array(),
    array(),),);

$parameters["reply_markup"] = json_encode($keyboard, true);
echo json_encode($parameters);


function callback($update){
    return $update["callback_query"];
}

function sendKeyboard($chatid, $text) {
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    $keyboard = ['inline_keyboard' => [[["text" => "Needs Parlare", "callback_data" => "needsParlare"],
    ["text" => "Wants Parlare", "callback_data" => "wantsParlare"],
    ["text" => "Needs Guardare+Parlare", "callback_data" => "needsGuardareParlare"],
    ["text" => "Wants Guardare+Parlare", "callback_data" => "wantsGuardareParlare"]]]];
    $parameters["reply_markup"] = json_encode($keyboard, true);
    echo json_encode($parameters);
}

if(callback($update) != null) {
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
*/