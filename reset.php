<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

$jdat["state"]=0;
$jdat["players"]=[];

gamedataWrite(); // VARIABLE : $jdat

exec("./tsEdit.bin");

header("Location: admin.php");

?>
