<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

$jdat["state"]=0;
$jdat["players"]=[];
$jdat['lastwrite']=time();

gamedataWrite(); // VARIABLE : $jdat

header("Location: admin.php");

?>
