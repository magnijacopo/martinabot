<?php

$message = isset($update['message']) ? $update['message'] : "";
$messageid = isset($message['message_id']) ? $message['message_id'] : "";
$chatid = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$cbid = $update["callback_query"]["from"]["id"];
$cbdata = $update["callback_query"]["data"];

function callback($up){
    return $up["callback_query"];
}

function apiRequest($metodo){
    $req = file_get_contents(api.$metodo);
    return $req;
}

function send($chatid, $text){
    header("Content-Type: application/json");
    $parameters = array('chat_id' => $chatid, "text" => $text);
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}

function keyboard($tasti, $text, $cd){
$tasti2 = $tasti;

$tasti3 = json_encode($tasti2);

    if(strpos($text, "\n")){
        $text = urlencode($text);
    }

apiRequest("sendMessage?text=$text&parse_mode=Markdown&chat_id=$cd&reply_markup=$tasti3");
}

function inlinekeyboard($menud, $chat, $text){
$menu = $menud;
    
    if(strpos($text, "\n")){
        $text = urlencode($text);
    }
    
    $d2 = array(
    "inline_keyboard" => $menu,
    );
    
    $d2 = json_encode($d2);
    
    return apiRequest("sendMessage?chat_id=$chat&parse_mode=Markdown&text=$text&reply_markup=$d2");
}


if(strpos($text, "/start") === 0 ) {
    send($chatid, "Benvenuto, sono la tua commessa personale!");
    $but[] = array(array("text" => "Needs Guardare", "callback_data" => "needsGuardare"),);
    $but[] = array(array("text" => "Wants Guardare", "callback_data" => "wantsGuardare"),);
    $but[] = array(array("text" => "Needs Guardare+Parlare", "callback_data" => "needsGuardareParlare"),);
    $but[] = array(array("text" => "Wants Guardare+Parlare", "callback_data" => "wantsGuardareParlare"),);
    inlineKeyboard($but, $chatid, "Scegli che questionario farà la prossima persona!");

} else {
    send($chatid, "Mi spiace ma non sono in grado di capire quel che dici, prova a ripetermelo diversamente!");
}

if(callback($update)){
    if($cbdata == "ciao1"){
        send($cbid, "hai cliccato il bottone 1");
    }
}