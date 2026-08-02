<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

$actionIsValid=True;

// Set points logic
if(isset($_GET['decred'])) {
	if($jdat["ptA"]>0)
		$jdat["ptA"]=$jdat["ptA"]-1;
	else
        $actionIsValid=False;
} else if(isset($_GET['incred'])) {
	$jdat["ptA"]=$jdat["ptA"]+1;
} else if(isset($_GET['decblue'])) {
	if($jdat["ptB"]>0) 
        $jdat["ptB"]=$jdat["ptB"]-1;
    else
        $actionIsValid=False;
} else if(isset($_GET['incblue'])) {
	$jdat["ptB"]=$jdat["ptB"]+1;
} else {
    $actionIsValid=False;
}

if($actionIsValid) {
    gamedataWrite(); // VARIABLE : $jdat
    exec("./tsEdit.bin");
} else {
    http_response_code(400);
    echo "Punteggio non modificato!";
}
?>
