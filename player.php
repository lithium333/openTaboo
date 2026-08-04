<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Start</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="stylesheet" href="styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<h1 style='text-align:center;'>openTaboo
<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

// Game State -> 0: INIT, 1: PLAYER ENTERING, 2: RUNNING
switch($jdat["state"]) {
	case 0:
        echo "⏳</h1>\n"; // <h1> closing
		echo "<h3 style='text-align:center;'>Attendere che il caposala imposti i parametri...</h3>\n";
		echo "<div class='loaderbar'></div>\n";
		break;
	case 1:
        echo "📝</h1>\n"; // <h1> closing
		echo "<div class='formContainer'>\n";
		echo "<form action='join.php' method='get'>\n";
		echo "<h3>Scegli il tuo nome:</h3>\n";
		echo "<input type='textbox' name='nick' id='nick'>\n";
		echo "<h3>Scegli il tuo slot:</h3>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($jdat["players"][$i]===null) {
				echo "<h3><input type='radio' name='slot' id='slot' value='".($i+1)."'>";
				if($i%2)
					echo "SLOT ".($i+1)." 🔵</h3>";
				else
					echo "SLOT ".($i+1)." 🔴</h3>";
			}
		}
		echo "<br><input class='tastoGiocatore' type='submit' value='PROCEDI' onclick='stopRefresh()' />\n";
		echo "</form>\n</div>\n";
		break;
	case 2:
        echo "🕹️</h1>\n"; // <h1> closing
		echo "<h2>VAI ALLA TUA PAGINA:</h2>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>SLOT ".($i+1)." 🔵";
			else
				echo "<h3>SLOT ".($i+1)." 🔴";
			echo " <a href='run.php?id=".($i+1)."'>".htmlentities($jdat["players"][$i])."</a></h3>";
		}
	default:
		//unmanaged
}

?>
</body>
<script>

<?php getUpdates(); ?>

function stopRefresh() {
    eventUpdate.close();
}
    
</script>
</html>
