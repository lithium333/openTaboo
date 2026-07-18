<?php

include "core.php";

// Exract card and remove
cardsLoad();
if($card_count==0) { //refresh cards no more available
    cardsInit();
}
cardsExtract(); // VARIABLE : $jcard_extracted_F
cardsPut();

// Shift Next
gamedataRead(); // VARIABLE : $jdat
$jdat["turno"] = ($jdat["turno"]+1)%($jdat["nplayers"]);
$jdat["curskip"]=$jdat["skips"];
$jdat['lastwrite']=time();
gamedataWrite(); // VARIABLE : $jdat
file_put_contents($path_card_current,$jcard_extracted_F); // INSERT EXTRACTED CARD
file_put_contents("timecnt.txt",(new DateTime())->format('Uv')); // RESET TIMER

header("Location: admin.php");

?>
