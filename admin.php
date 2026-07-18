<!DOCTYPE html>
<html>
<head>
  <title>openTaboo Admin</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<h1>openTaboo Control Center</h1>
<?php

include "core.php";

gamedataRead(); // VARIABLE : $jdat

// Game State -> 0: INIT, 1: PLAYER ENTERING, 2: RUNNING, 3: END
switch($jdat["state"]) {
	case 0:
		echo "<form action='setrules.php' method='get'>\n";
		echo "<br>Tempo [s]:<br>\n";
		echo "<input type='number' id='time'  name='time' value='".$jdat["time"]."' /><br>\n";
		echo "<br>Turni per giocatore:<br>\n";
		echo "<input type='number' id='rounds'  name='rounds' value='".$jdat["rounds"]."' /><br>\n";
		echo "<br>&quot;Passo&quot; disponibili:<br>\n";
		echo "<input type='number' id='skips'  name='skips' value='".$jdat["skips"]."' /><br>\n";
		echo "<br>Giocatori:<br>\n";
		echo "<input type='number' id='nplayers'  name='nplayers' value='".$jdat["nplayers"]."' /><br>\n";
		echo "<br><input type='submit' value='PROCEDI'/>\n";
		echo "</form>\n";
		break;
	case 1:
		echo "<h2>Giocatori:</h2>\n";
		$complete=true;
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>🔵 ";
			else
				echo "<h3>🔴 ";
			if($jdat["players"][$i]!==null) {
				echo htmlentities($jdat["players"][$i])."</h3>\n";
			} else {
				echo "SLOT ".($i+1)." VUOTO!</h3>\n";
				$complete=false;
			}
		}
		if($complete) {
			echo "<h3><a href='ready.php'>VIA!</a></h3>";
		}
		echo "<h3><a href='reset.php'>REIMPOSTA</a></h3>";
		break;
	case 2: // GAME RUNNING
    case 3: // GAME END
		echo "<h2>Giocatori:</h2>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>🔵 ";
			else
				echo "<h3>🔴 ";
			echo htmlentities($jdat["players"][$i])." [".($i+1)."]</h3>\n";
		}
		echo "<h2>PUNTEGGI</h3>";
		echo "<h3>🔴 <a style='text-decoration:none' href='setpt.php?decred'>-</a> ".$jdat["ptA"]."pt <a style='text-decoration:none' href='setpt.php?incred'>+</a></h3>";
		echo "<h3>🔵 <a style='text-decoration:none' href='setpt.php?decblue'>-</a> ".$jdat["ptB"]."pt <a style='text-decoration:none' href='setpt.php?incblue'>+</a></h3>";
		echo "<h3>Round: ".($jdat["curround"]+1)."/".$jdat["rounds"]."</h3>";
		if($jdat["state"]==2)
			echo "<h3>Turno: ".($jdat["turno"]+1)." <a style='text-decoration:none' href='turnosucc.php'>AVANTI</a></h3>";
		echo "<h3><a href='reset.php'>REIMPOSTA</a></h3>";
		break;
	default:
		//umanaged
}

?>
</body>

<script>

var ts = <?php echo $jdat['lastwrite'];?>;

var eventUpdate = new EventSource("getupdate.php");

eventUpdate.onmessage = function(event) {   
    if(ts!=event.data)
        window.location.reload();
};
    
</script>

</html>
