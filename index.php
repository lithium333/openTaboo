<?php

if($_SERVER['REMOTE_ADDR']=="127.0.0.1") {
	header("Location: panel.html");
} else {
	header("Location: player.php");
}

?>
