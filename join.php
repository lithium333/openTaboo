<?php

if(!isset($_GET['slot']))
	die("<h1>Torna indietro e scegli uno slot!</h1>");

$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat['players'][$_GET['slot']-1]=$_GET['nick'];
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
header("Location: run.php?id=".$_GET['slot']);

?>
