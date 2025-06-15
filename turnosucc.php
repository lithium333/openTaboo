<?php
// edit json
$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat["turno"] = ($jdat["turno"]+1)%($jdat["nplayers"]);
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
file_put_contents("timecnt.txt",(new DateTime())->format('Uv')); // RESET TIMER
header("Location: admin.php");
?>
