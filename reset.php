<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

$jdat["state"]=STATE_INIT;
$jdat["players"]=[];

gamedataWrite(); // VARIABLE : $jdat

exec("./tsEdit.bin");

?>
