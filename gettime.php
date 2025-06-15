<?php

$oldts = file_get_contents("timecnt.txt");
echo (new DateTime())->format('Uv')-$oldts;
?>
