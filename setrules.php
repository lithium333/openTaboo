<?php

include "core.php";

$g_time = $_GET['time'];
$g_rounds = $_GET['rounds'];
$g_skips = $_GET['skips'];
$g_nplayers = $_GET['nplayers'];

// Game Rules
if($g_time<=0)
	die("<h1>Il turno deve durare un numero positivo e diverso da 0 di secondi!</h1>");
if($g_rounds<1)
	die("<h1>Deve esserci almeno un turno!</h1>");
if($g_skips<0)
	die("<h1>Specificare un valore positivo o nullo per i passo!</h1>");
if($g_nplayers<4)
	die("<h1>Almeno 4 giocatori è un must!</h1>");

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
$jdat["state"]=1;
gamedataWrite(); // VARIABLE : $jdat

exec("./tsEdit.bin");

header("Location: admin.php");

?>
