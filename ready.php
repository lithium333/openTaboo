<?php

// Define path
$path_cards = "./cards/mazzo.json";
$path_origC = "./cards/orig.json";
$path_userC = "./cards/carta.json";

// Refresh card and remove one
$jcardsDB_F = file_get_contents($path_origC); 
$jcardsDB_J = json_decode($jcardsDB_F);
$card_count = count($jcardsDB_J);
$card_extractedN = random_int(0,($card_count-1));
$jcard_extracted_F = json_encode($jcardsDB_J[$card_extractedN]);
$jcardsDB_J_s1 = array_slice($jcardsDB_J,0,$card_extractedN);
$jcardsDB_J_s2 = array_slice($jcardsDB_J,($card_extractedN+1));
$jcardsDB_J = array_merge($jcardsDB_J_s1,$jcardsDB_J_s2);
$jcardsDB_F = json_encode($jcardsDB_J);
file_put_contents($path_cards,$jcardsDB_F);

$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
$jdat["ptA"]=0;
$jdat["ptB"]=0;
$jdat["turno"]=0;
$jdat["state"]=2;
$jdat['lastwrite']=time();
$jraw = json_encode($jdat);
file_put_contents("game.json",$jraw);
file_put_contents($path_userC,$jcard_extracted_F); // INSERT EXTRACTED CARD
file_put_contents("timecnt.txt",(new DateTime())->format('Uv')); // RESET TIMER
header("Location: admin.php");
?>
