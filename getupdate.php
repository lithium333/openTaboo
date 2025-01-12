<?php
$jfile = file_get_contents("./game.json");
$jdata = json_decode($jfile,true);
echo $jdata['lastwrite'];
?>
