<?php

define('token', 'iltuotoken');

include 'source.php';

if($text == "/start"){
    send($cid, "Benvenuto, sono la tua commessa personale!");


}

if(callback($update)){
    if($cbdata == "ciao1"){
    send($cbid, "hai cliccato il bottone 1");
    }

    $but[] = array(array("text" => "Needs Guardare", "callback_data" => "needsGuardare"),);
    $but[] = array(array("text" => "Wants Guardare", "callback_data" => "wantsGuardare"),);
    $but[] = array(array("text" => "Needs Guardare+Parlare", "callback_data" => "needsGuardareParlare"),);
    $but[] = array(array("text" => "Wants Guardare+Parlare", "callback_data" => "wantsGuardareParlare"),);
    inlineKeyboard($but, $cid, "Scegli che questionario farà la prossima persona!");
}