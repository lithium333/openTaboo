<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

// Get timer status
exec("./readtime.bin", $ret_value, $ret_code);

if( ($ret_code!=0) or ($ret_value[0]>($jdat["time"]*1000)) )
    die("<h1>Query fuori tempo</h1>");

// Set points logic
if(isset($_GET['success'])) {
    $turnoteam=$jdat['turno']%2;
    if($turnoteam) {
        $jdat["ptB"]++;
    } else {
        $jdat["ptA"]++;
    }
} else if(isset($_GET['skipped'])) {
	if($jdat["curskip"]>0)
        $jdat["curskip"]--;
    else
        die("<h1>No skips</h1>");
} else {
	die("<h1>Query non valida!</h1>");
}

// Exract next card and remove
cardsLoad();
if($card_count==0) { //refresh cards no more available
    cardsInit();
}
cardsExtract(); // VARIABLE : $jcard_extracted_F
cardsPut();
file_put_contents($path_card_current,$jcard_extracted_F); // INSERT EXTRACTED CARD

gamedataWrite(); // VARIABLE : $jdat

exec("./tsEdit.bin");

?>
