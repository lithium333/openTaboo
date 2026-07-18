<?php

if($_SERVER['REMOTE_ADDR']=="127.0.0.1") {
	header("Location: admin.php");
} else {
	header("Location: player.php");
}

?>
