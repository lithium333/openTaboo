<?php

$g_time = $_GET['time'];
$g_rounds = $_GET['rounds'];
$g_skips = $_GET['skips'];
$g_nplayers = $_GET['nplayers'];

if($g_time<=0)
	die("<h1>Il turno deve durare un numero positivo e diverso da 0 di secondi!</h1>");
if($g_rounds<1)
	die("<h1>Deve esserci almeno un turno!</h1>");
if($g_skips<0)
	die("<h1>Specificare un valore positivo o nullo per i passo!</h1>");
if($g_nplayers<4)
	die("<h1>Almeno 4 giocatori è un must!</h1>");

// edit json
$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat["time"] = (int)$g_time;
$jdat["rounds"] = (int)$g_rounds;
$jdat["skips"] = (int)$g_skips;
$jdat["nplayers"] = (int)$g_nplayers;
$jdat["players"]=[];
for($i=0;$i<$jdat["nplayers"];$i++) {
	$jdat["players"][] = null;
}
$jdat["state"]=1;
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
header("Location: admin.php");

?>
