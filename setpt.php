<?php
$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);

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
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
header("Location: admin.php");
?>
