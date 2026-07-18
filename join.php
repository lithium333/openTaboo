<?php

include "core.php";

if(!isset($_GET['slot']))
	die("<h1>Torna indietro e scegli uno slot!</h1>");

gamedataRead(); // VARIABLE : $jdat

// check if slot is already occupied (wrong request)
if($jdat['players'][$_GET['slot']-1]!=null) {
	header("Location: run.php?id=".$_GET['slot']);
	exit();
}


// write changes
$jdat['players'][$_GET['slot']-1]=$_GET['nick'];
$jdat['lastwrite']=time();

gamedataWrite(); // VARIABLE : $jdat




header("Location: run.php?id=".$_GET['slot']);

?>
