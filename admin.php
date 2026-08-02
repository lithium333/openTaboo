<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Admin</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <meta charset="UTF-8">
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
		echo "<h3>📥&nbsp;<a href='javascript:setRules();'>NEXT</a></h3>";
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
			echo "<h3>▶️&nbsp;<a href='javascript:startGame();'>START</a></h3>";
		}
		echo "<h3>❌&nbsp;<a href='javascript:resetRules();'>RESET</a></h3>";
		
		break;
	case 2: // GAME RUNNING
	case 3: // GAME END
		echo "<h2>👤&nbsp;GIOCATORI</h2>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>&nbsp;&nbsp;🔵 ";
			else
				echo "<h3>&nbsp;&nbsp;🔴 ";
			echo htmlentities($jdat["players"][$i])." [".($i+1)."]</h3>\n";
		}
		echo "<h2>🎯&nbsp;PUNTEGGI</h3>";
		echo "<h3>&nbsp;&nbsp;🔴 <a style='text-decoration:none' href=\"javascript:setPt('decred')\">-</a>";
		echo "&nbsp;".$jdat["ptA"]." pt&nbsp;";
		echo "<a style='text-decoration:none' href=\"javascript:setPt('incred')\">+</a></h3>";
		echo "<h3>&nbsp;&nbsp;🔵 <a style='text-decoration:none' href=\"javascript:setPt('decblue')\">-</a>";
		echo "&nbsp;".$jdat["ptB"]." pt&nbsp;";
		echo "<a style='text-decoration:none' href=\"javascript:setPt('incblue')\">+</a></h3>";
		echo "<h3>Round: ".($jdat["curround"]+1)."/".$jdat["rounds"];
		if($jdat["state"]==2)
			echo " Turno: ".($jdat["turno"]+1);
		echo "</h3>\n";
		if($jdat["state"]==2) echo "<h3>⏩&nbsp;<a style='text-decoration:none' href='javascript:nextShift();'>AVANTI</a></h3>";
		echo "<h3>❌&nbsp;<a href='javascript:resetRules();'>RESET</a></h3>";
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
