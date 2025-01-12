<?php
$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat["ptA"]=0;
$jdat["ptB"]=0;
$jdat["turno"]=0;
$jdat["state"]=2;
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
header("Location: admin.php");
?>
