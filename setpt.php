<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

// Set points logic
if(isset($_GET['decred'])) {
	if($jdat["ptA"]>0) $jdat["ptA"]=$jdat["ptA"]-1;
} else if(isset($_GET['incred'])) {
	$jdat["ptA"]=$jdat["ptA"]+1;
} else if(isset($_GET['decblue'])) {
	if($jdat["ptB"]>0) $jdat["ptB"]=$jdat["ptB"]-1;
} else if(isset($_GET['incblue'])) {
	$jdat["ptB"]=$jdat["ptB"]+1;
} else {
	die("<h1>Query non valida!</h1>");
}

$jdat['lastwrite']=time();
gamedataWrite(); // VARIABLE : $jdat

header("Location: admin.php");
?>
