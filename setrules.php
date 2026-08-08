<?php

include "core.php";

$g_time = $_GET['time'];
$g_rounds = $_GET['rounds'];
$g_skips = $_GET['skips'];
$g_nplayers = $_GET['nplayers'];

// Rule 1 : Time Positive.
if($g_time<0) {
	http_response_code(400);
	die("Il turno deve durare un numero positivo e diverso da 0 di secondi!");
}

// Rule 2 : Rounds Positive.
if($g_rounds<1) {
	http_response_code(400);
	die("Deve esserci almeno un turno!");
}

// Rule 3 : Skips not negative.
if($g_skips<0) {
	http_response_code(400);
    die("Specificare un valore positivo o nullo per i passo!");
}

// Rule 4 : Minimum 4 players.
if($g_nplayers<4) {
	http_response_code(400);
	die("Almeno 4 giocatori!");
}

// Rule 5 : No odd players.
if($g_nplayers%2) {
	http_response_code(400);
	die("I giocatori devono essere in numero pari!");
}

// GameData Change
gamedataRead(); // VARIABLE : $jdat
$jdat["time"] = (int)$g_time;
$jdat["rounds"] = (int)$g_rounds;
$jdat["skips"] = (int)$g_skips;
$jdat["nplayers"] = (int)$g_nplayers;
$jdat["players"]=[];
for($i=0;$i<$jdat["nplayers"];$i++) {
	$jdat["players"][] = null;
}
$jdat["state"]=STATE_JOIN;
gamedataWrite(); // VARIABLE : $jdat

exec("./tsEdit.bin");

?>
