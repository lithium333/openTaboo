<?php

// Relative path to JSON files
$path_gamedata = "game.json";
$path_card_current = "./cards/carta.json";
$path_cards_available = "./cards/mazzo.json";
$path_cards_full = "./cards/orig.json";

// GameData Read/Write
function gamedataRead() {
    global $path_gamedata, $jdat;
    $jraw = file_get_contents($path_gamedata);
    $jdat = json_decode($jraw,true);
}
function gamedataWrite() {
    global $path_gamedata, $jdat;
    $jraw = json_encode($jdat);
    file_put_contents($path_gamedata,$jraw);
}

// Cards Management
function cardsInit() {
    global $path_cards_full, $jcardsDB_J, $card_count;
    $jcardsDB_F = file_get_contents($path_cards_full); 
    $jcardsDB_J = json_decode($jcardsDB_F);
    $card_count = count($jcardsDB_J);
}
function cardsLoad() {
    global $path_cards_available, $jcardsDB_J, $card_count;
    $jcardsDB_F = file_get_contents($path_cards_available);
    $jcardsDB_J = json_decode($jcardsDB_F);
    $card_count = count($jcardsDB_J);
}
function cardsExtract() {
    global $jcardsDB_J, $card_count, $jcard_extracted_F;
    $card_extractedN = random_int(0,($card_count-1));
    $jcard_extracted_F = json_encode($jcardsDB_J[$card_extractedN]);
    $jcardsDB_J_s1 = array_slice($jcardsDB_J,0,$card_extractedN);
    $jcardsDB_J_s2 = array_slice($jcardsDB_J,($card_extractedN+1));
    $jcardsDB_J = array_merge($jcardsDB_J_s1,$jcardsDB_J_s2);
}
function cardsPut() {
    global $path_cards_available,$jcardsDB_J;
    $jcardsDB_F = json_encode($jcardsDB_J);
    file_put_contents($path_cards_available,$jcardsDB_F);
}

// Get Updates to refresh
function getUpdates() {
    exec("./tsRead.bin", $ret_value);
    echo "var ts = ".$ret_value[0].";\n";
    echo "var eventUpdate = new EventSource(\"tsGet.cgi\");\n";
    echo "eventUpdate.onmessage = function(event) {\n";
    echo "if(ts!=event.data)\n";
    echo "window.location.reload();\n";
    echo "};\n";
}

?>
