<?php

define('api', 'https://api.telegram.org/bot'.token.'/');

$data = file_get_contents("php://input");
$update = json_decode($data, true);

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

function send($id, $text){
    if(strpos($text, "\n")){
        $text = urlencode($text);
    }
    return apiRequest("sendMessage?text=$text&parse_mode=HTML&chat_id=$id");
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