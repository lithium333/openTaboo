<?php

$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat["state"]=0;
$jdat["players"]=[];
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
header("Location: admin.php");

?>
