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
$jdat["turno"]++;
if($jdat["turno"]>=$jdat["nplayers"]) {
    $jdat["curround"]++;
    if($jdat["curround"]>=$jdat["rounds"]) {
        $jdat["state"]=3; // rounds end
        $jdat["curround"]=$jdat["rounds"]-1;
    } else {
        $jdat["turno"]=0;
    }
}
$jdat["curskip"]=$jdat["skips"];
gamedataWrite(); // VARIABLE : $jdat
file_put_contents($path_card_current,$jcard_extracted_F); // INSERT EXTRACTED CARD
exec("./tsEdit.bin");
exec("./settime.bin");
header("Location: admin.php");

?>
