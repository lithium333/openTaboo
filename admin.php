<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Admin</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <meta charset="UTF-8">
  <style>
  .controllerButton {
  font-size: 1em;
  padding: 2px 2px 2px 2px;
  color: red;
  background: white;
  border-width: 3px;
  border-style: solid;
  border-color: red;
  border-radius: 6px;
  }
  .controllerButton:hover {
  color: black;
  background: yellow;
  }
  .tastoPunteggio {
  border: 2px solid transparent;
  background: transparent;
  padding: 0 0 0 0;
  font-size: inherit;
  }
  .tastoPunteggio:hover {
  border: 2px solid blue;
  }
  </style>
</head>
<body>
<h1 style="color:green;text-align:center;">openTaboo Admin 🛡️</h1>
<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

// Game State -> 0: INIT, 1: PLAYER ENTERING, 2: RUNNING, 3: END
switch($jdat["state"]) {
	case 0: // START
		echo "<form action='javascript:setRules();' method='get' id='rulesForm' name='rulesForm'>\n";
		echo "<br>Tempo [s]:<br>\n";
		echo "<input type='number' id='time'  name='time' value='".$jdat["time"]."' /><br>\n";
		echo "<br>Turni per giocatore:<br>\n";
		echo "<input type='number' id='rounds'  name='rounds' value='".$jdat["rounds"]."' /><br>\n";
		echo "<br>&quot;Passo&quot; disponibili:<br>\n";
		echo "<input type='number' id='skips'  name='skips' value='".$jdat["skips"]."' /><br>\n";
		echo "<br>Giocatori:<br>\n";
		echo "<input type='number' id='nplayers'  name='nplayers' value='".$jdat["nplayers"]."' /><br>\n";
		echo "</form>\n";
		echo "<p><button class='controllerButton' onclick='javascript:setRules();'>📥&nbsp;NEXT</button></p>";
		break;
	case 1: // PLAYER BOARDING
		echo "<h2>👤&nbsp;GIOCATORI</h2>\n";
		$complete=true;
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>&nbsp;&nbsp;🔵 ";
			else
				echo "<h3>&nbsp;&nbsp;🔴 ";
			if($jdat["players"][$i]!==null) {
				echo htmlentities($jdat["players"][$i])."</h3>\n";
			} else {
				echo "SLOT ".($i+1)." EMPTY!</h3>\n";
				$complete=false;
			}
		}
		if($complete) {
			echo "<p><button class='controllerButton' onclick='javascript:startGame();'>▶️&nbsp;START</button></p>";
		}
		echo "<p><button class='controllerButton' onclick='javascript:resetRules();'>❌&nbsp;RESET</button></p>";
		
		break;
	case 2: // GAME RUNNING
	case 3: // GAME END
		echo "<h2>👤&nbsp;GIOCATORI</h2>\n";
        $stringa_red = "";
        $stringa_blu = "";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				$stringa_blu=$stringa_blu.htmlentities($jdat["players"][$i])." [".($i+1)."] ";
			else
				$stringa_red=$stringa_red.htmlentities($jdat["players"][$i])." [".($i+1)."] ";
		}
		echo "<h3>&nbsp;&nbsp;🔴 ".$stringa_red."</h3>\n";
        echo "<h3>&nbsp;&nbsp;🔵 ".$stringa_blu."</h3>\n";   
		echo "<h2>🎯&nbsp;PUNTEGGI</h3>";
		echo "<h3>&nbsp;&nbsp;🔴 <button class='tastoPunteggio' onclick=\"javascript:setPt('decred');\">🔽</button>";
		echo "&nbsp;".$jdat["ptA"]." pt&nbsp;";
		echo "<button class='tastoPunteggio' onclick=\"javascript:setPt('incred');\">🔼</button></h3>";
		echo "<h3>&nbsp;&nbsp;🔵 <button class='tastoPunteggio' onclick=\"javascript:setPt('decblue');\">🔽</button>";
		echo "&nbsp;".$jdat["ptB"]." pt&nbsp;";
		echo "<button class='tastoPunteggio' onclick=\"javascript:setPt('incblue');\">🔼</button></h3>";
		echo "<h3>Round: ".($jdat["curround"]+1)."/".$jdat["rounds"];
		if($jdat["state"]==2)
			echo " Turno: ".($jdat["turno"]+1);
		echo "</h3>\n";
		if($jdat["state"]==2) echo "<p><button class='controllerButton' onclick='javascript:nextShift();'>⏩&nbsp;AVANTI</button></p>";
		echo "<p><button class='controllerButton' onclick='javascript:resetRules();'>❌&nbsp;RESET</button></p>";
		break;
	default:
		//umanaged
}


?>
<h4><span style="font-weight: bold;color:white;background:red;" id="serverAns" name="serverAns"></span></h4>
</body>

<script>

function setRules() {
	var rTime = document.getElementById('time').value;
	var rRounds = document.getElementById('rounds').value;
	var rSkips = document.getElementById('skips').value;
	var rNplayers = document.getElementById('nplayers').value;
	var reqstr = "setrules.php?time=" + rTime + "&rounds=" + rRounds + "&skips=" + rSkips + "&nplayers=" + rNplayers;
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", reqstr, true);
	xmlHttp.onload = function () {
		if(xmlHttp.status==400)
			document.getElementById('serverAns').innerHTML=xmlHttp.response;
	};
	xmlHttp.send();
}

function resetRules() {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "reset.php", true);
	xmlHttp.send();
}

function startGame() {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "ready.php", true);
	xmlHttp.send();
}

function nextShift() {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "turnosucc.php", true);
	xmlHttp.send();
}

function setPt(reqParam) {
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "setpt.php?"+reqParam, true);
	xmlHttp.onload = function () {
		if(xmlHttp.status==400) {
			document.getElementById('serverAns').style.background="#FF7F00";
            document.getElementById('serverAns').innerHTML=xmlHttp.response;
			msgEffect();
		}
	};
	xmlHttp.send();
}

<?php getUpdates(); ?>
	
</script>

</html>
