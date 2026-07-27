<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Player</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body>
<h1 style='text-align:center;'>openTaboo</h1>
<?php

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
				echo "<button id='buttOK' onclick=\"submitSuccess()\" name=\"success\">PRESA!</button>\n";
				if($jdat['curskip']>0)
					echo "<button id='buttSK' onclick=\"submitSkip()\" name=\"skipped\">PASSO: ".$jdat['curskip']."</button>\n";
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
		    echo "<h2 style='text-align:center;'><span id='tempo'>XX.X</span></h2>\n";
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

<style>
.carta {
  border:3px solid;
  width:250px;
  height:45vh;
  margin:0 auto;
  margin-top:32px;
  border-radius:12px;
}
.loaderbar {
  width: 48px;
  aspect-ratio: .75;
  --c1: no-repeat linear-gradient(#ff0000 0 0);
  --c2: no-repeat linear-gradient(#00ff00 0 0);
  --c3: no-repeat linear-gradient(#0000ff 0 0);
  background: 
	var(--c1) 0%   50%,
	var(--c2) 50%  50%,
	var(--c3) 100% 50%;
  animation: l7 1s infinite linear alternate;
  margin: auto;
}
@keyframes l7 {
  0%  {background-size: 20% 50% ,20% 50% ,20% 50% }
  20% {background-size: 20% 20% ,20% 50% ,20% 50% }
  40% {background-size: 20% 100%,20% 20% ,20% 50% }
  60% {background-size: 20% 50% ,20% 100%,20% 20% }
  80% {background-size: 20% 50% ,20% 50% ,20% 100%}
  100%{background-size: 20% 50% ,20% 50% ,20% 50% }
}
</style>

</body>
</html>
