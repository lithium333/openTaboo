<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Player</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="styles.css">
</head>

<body>
<h1 style='text-align:center;'>openTaboo
<?php

if(!isset($_GET["id"]))
	header("Location: player.php");

include "core.php";

gamedataRead(); // VARIABLE : $jdat

$showingcnt=false;
switch($jdat["state"]) {
	case 0:
		header("Location: player.php");
		break;
	case 1:
		if(($jdat["players"][$_GET['id']-1])==null)
			header("Location: player.php");
		echo "⏳</h1>\n"; // <h1> closing
		echo "<h3>Player: ".$jdat["players"][$_GET['id']-1]."</h3>\n";
		echo "<h3>Aspetta che il caposala dia il via...</h3>\n";
		echo "<div class='loaderbar'></div>\n";
		break;
	case 2:
		// FUNC PRINT CARD
		function prtcarta() {
			global $path_card_current;
			$jcartaraw = file_get_contents($path_card_current);
			$jcartadat = json_decode($jcartaraw,true);
			echo "<div class='carta'>\n";
			echo "<h2 style='text-align:center;color:darkblue;' >".$jcartadat["soluz"]."</h2>\n";
			foreach($jcartadat["vietato"] as $parolabandita)
				echo "<h3 style='text-align:center;color:darkorange;' >".$parolabandita."</h3>\n";
			echo "</div>\n";
			
		}
	case 3:
        echo "🎮</h1>\n"; // <h1> closing
		// HEAD PLAYER PAGE
		$playerid=$_GET['id']-1;
		$teamid=$playerid%2; // 0 red ; 1 blu
		$turnoteam=$jdat['turno']%2;
		echo "<h3>".$jdat["players"][$_GET['id']-1];
		if($teamid) {
			echo " 🔵 ";
			$ptteam=$jdat['ptB'];
		} else {
			echo " 🔴 ";
			$ptteam=$jdat['ptA'];
		}
		echo "[".$_GET['id']."]<br>\n";
		// PRINT ROUND AND POINTS
		echo "ROUND: ".($jdat['curround']+1)."/".$jdat['rounds']."";
		echo " - TEAM: ".$ptteam." pt<br></h3>\n";
		if($jdat['state']==2) {
			//gestione turno
			if($playerid==$jdat['turno']) {
				echo "<h3>TURNO TUO!</h3>\n";
				prtcarta();
			} else {
				if($teamid==$turnoteam) {
					echo "<h3>Turno del tuo team, INDOVINA ❓</h3>\n";
					echo "<div class='carta'>\n";
					echo "<p style='text-align:center;font-size:40vh;color:blue;margin: 0 0;'>?</p>";
					echo "</div>\n";
				} else {
					echo "<h3>Turno team avversario, CONTROLLA 👀</h3>\n";
					prtcarta();
				}
			}
            $showingcnt=true;
		    echo "<h2 style='text-align:center;'><span id='tempo'>&nbsp;</span></h2>\n";
            if($playerid==$jdat['turno']) {
                echo "<button id='buttOK' onclick=\"submitSuccess()\" name=\"success\">PRESA!</button>\n";
				if($jdat['curskip']>0)
					echo "<button id='buttSK' onclick=\"submitSkip()\" name=\"skipped\">PASSO: ".$jdat['curskip']."</button>\n";
            }
		} else {
			echo "<h2>GAME END!</h2>\n";
		}
	default:
		//unmanaged
}

?>

<script>

function submitSuccess() {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "./nextcard.php?success", false);
	xmlHttp.send();
}

function submitSkip() {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "./nextcard.php?skipped", false);
	xmlHttp.send();
}

<?php
getUpdates();
if($showingcnt) {
	echo "var timeEnd = false;\n";
    echo "var tsmax = ".$jdat["time"].";";
	echo "var eventTimer = new EventSource(\"nph-gettime.cgi\");\n";
	echo "eventTimer.onmessage = function(event) {\n";
    echo "	var tsrnd = (event.data/1000).toFixed(1);\n";
    echo "	if (tsrnd>tsmax) {\n";
	echo "		document.getElementById(\"tempo\").innerHTML = \"<span style='color:#7F0000;'>TIME END: \"+tsmax+\" s</span>\";\n";
	echo "		if(timeEnd != true) {\n";
	echo "			timeEnd = true;\n";
    if($playerid==$jdat['turno']) {
	echo "				document.getElementById(\"buttOK\").remove();\n";
	echo "				document.getElementById(\"buttSK\").remove();\n";
 	}
	echo "		}\n";
	echo "	} else {\n";
	echo "		document.getElementById(\"tempo\").innerHTML = tsrnd + \" s\";\n";
	echo "	};\n";
	echo "};\n";
}
?>
</script>

</body>
</html>
