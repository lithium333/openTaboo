<?php

include "core.php";

cardsInit();
cardsExtract(); // VARIABLE : $jcard_extracted_F
cardsPut();

gamedataRead(); // VARIABLE : $jdat

$jdat["ptA"]=0;
$jdat["ptB"]=0;
$jdat["turno"]=0;
$jdat["state"]=2;
$jdat["curskip"]=$jdat["skips"];
$jdat['lastwrite']=time();

gamedataWrite(); // VARIABLE : $jdat

file_put_contents($path_card_current,$jcard_extracted_F); // INSERT EXTRACTED CARD
file_put_contents("timecnt.txt",(new DateTime())->format('Uv')); // RESET TIMER

header("Location: admin.php");
?>
