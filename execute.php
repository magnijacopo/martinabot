<?php

$content = file_get_contents("php://input");
$update = json_decode($content, true);

$variables_file = file_get_contents("variables.json");
$variables = json_decode($variables_file, true);
$tipo_questionario = $variables['tipo_questionario'];
$discorso_iniziato = $variables['discorso_iniziato'];

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
        setTipoQuestionario(1, "variables.json");
        send($chatid, "Hai scelto Needs Parlare! Scrivi ok, e inizierò a parlare al cliente!");
    } elseif(strpos($text, "2") === 0) {
        setTipoQuestionario(2, "variables.json");
        send($chatid, "Hai scelto Needs Parlare e Guardare, osservo un po' il cliente e poi gli parlerò");
    } elseif(strpos($text, "3") === 0) {
        setTipoQuestionario(3, "variables.json");
        send($chatid, "Hai scelto Wants Parlare, inizio subito a chiedere aiuto al cliente!");
    } elseif(strpos($text, "4") === 0) {
        setTipoQuestionario(4, "variables.json");
        send($chatid, "Hai scelto Wants Parlare e Guardare, osservo un po' il cliente e poi gli parlerò");
    }
}

function setTipoQuestionario($tipo, $file) {
    $variables_file = file_get_contents("variables.json");
    $variables = json_decode($variables_file, true);
    $variables['tipo_questionario'] = $tipo;
    file_put_contents($file, json_encode($variables));
}

function setDiscorsoIniziato($value, $file) {
    $variables_file = file_get_contents("variables.json");
    $variables = json_decode($variables_file, true);
    $variables['discorso_iniziato'] = $value;
    file_put_contents($file, json_encode($variables));
}

if ($tipo_questionario != 0) {

    if(strpos($text, "/stop") === 0 ){
        send($chatid, "Ok, cancello tutto. Scrivi /start per iniziare un nuovo questionario");
        setTipoQuestionario(0, "variables.json");
    }

    switch ($tipo_questionario) {
        // 1 = Needs Parlare
        case 1:
            if (strpos($text, "inizia") === 0) {
                sleep(20);
                send($chatid, "Benvenuto! Posso aiutarti?");
            }
            if (strpos($text, "no") !== false) {
                if ($discorso_iniziato == false) {
                    send($chatid, "Va bene, se hai bisogno sono disponibile! Scrivimi aiuto");
                }
                if ($discorso_iniziato == true) {
                    send($chatid, "Ok, hai in mente altre caratteristiche?
                    \nImpermeabile, capiente, resistente? Dimmi con che caratteristiche lo vorresti");
                }
            }
            if ( strpos($text, "ok") !== false || strpos($text, "si") !== false || strpos($text, "bene") !== false
            || strpos($text, "aiuto") === 0 ){
                if($discorso_iniziato == false) {
                    send($chatid, "Perfetto, cosa stai cercando?");
                    setDiscorsoIniziato(true, "variables.json");
                }
                if ($discorso_iniziato == true) {
                    send($chatid, "Ok, hai in mente altre caratteristiche?
                    \nImpermeabile, capiente, resistente? Dimmi con che caratteristiche lo vorresti. 
                    \nSe non ti interessa nessuna caratteristica particolare dimmi nessuna");
                }
            }
            if (strpos($text, "zaino") !== false || strpos($text, "zainetto") !== false) {
                send($chatid, "Ti serve per una escursione in montagna?");
            }
            if ( strpos($text, "impermeabile") !== false || strpos($text, "capiente") !== false
                || strpos($text, "resistente") !== false || strpos($text, "nessuna") !== false ) {
                send($chatid, "Lo vorresti da uomo o da donna?");
            }
            if (strpos($text, "uomo") !== false ) {
                send($chatid, "Secondo me il modello NH500 30L è quello più adatto a te!");
            } elseif (strpos($text, "donna") !== false ) {
                send($chatid, "Secondo me il modello MH100 30L è quello più adatto a te!");
            }
            break;

        // 2 = Needs Parlare e Guardare
        case 2:
            if (strpos($text, "inizia") === 0) {
                sleep(60);
                send($chatid, "Ciao! Ho visto che stai guardando degli zaini, posso aiutarti a scegliere?");
            }
            if (strpos($text, "no") !== false) {
                if ($discorso_iniziato == false) {
                    send($chatid, "Va bene, se hai bisogno sono disponibile! Scrivimi aiuto");
                }
                if ($discorso_iniziato == true) {
                    send($chatid, "Ok, hai in mente altre caratteristiche?
                    \nImpermeabile, capiente, resistente? Dimmi con che caratteristiche lo vorresti");
                }
            }
            if ( strpos($text, "ok") !== false || strpos($text, "si") !== false || strpos($text, "bene") !== false
                || strpos($text, "aiuto") === 0 ){
                if($discorso_iniziato == false) {
                    send($chatid, "Perfetto, cosa stai cercando?");
                    setDiscorsoIniziato(true, "variables.json");
                }
                if ($discorso_iniziato == true) {
                    send($chatid, "Ok, hai in mente altre caratteristiche?
                    \nImpermeabile, capiente, resistente? Dimmi con che caratteristiche lo vorresti. 
                    \nSe non ti interessa nessuna caratteristica particolare dimmi nessuna");
                }
            }
            if (strpos($text, "zaino") !== false || strpos($text, "zainetto") !== false) {
                send($chatid, "Ti serve per una escursione in montagna?");
            }
            if ( strpos($text, "impermeabile") !== false || strpos($text, "capiente") !== false
                || strpos($text, "resistente") !== false || strpos($text, "nessuna") !== false ) {
                send($chatid, "Lo vorresti da uomo o da donna?");
            }
            if (strpos($text, "uomo") !== false ) {
                send($chatid, "Secondo me il modello NH500 30L è quello più adatto a te!");
            } elseif (strpos($text, "donna") !== false ) {
                send($chatid, "Secondo me il modello MH100 30L è quello più adatto a te!");
            }
            break;


        case 3:
            send($chatid, "Stiamo ancora sviluppando questo questionario");
            break;
        case 4:
            send($chatid, "Stiamo ancora sviluppando questo questionario");
            break;
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