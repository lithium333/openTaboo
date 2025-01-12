<html>
<body>
<h1>Taboo Control Center</h1>
<?php

$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);

// 0: sby, 1: players adding, 2:running
echo "[debug] state: ".$jdat["state"]."<br>\n";
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
	case 2:
		echo "<h2>Giocatori:</h2>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($i%2)
				echo "<h3>🔵 ";
			else
				echo "<h3>🔴 ";
			echo htmlentities($jdat["players"][$i])."</h3>\n";
		}
		echo "<h2>PUNTEGGI</h3>";
		echo "<h3>🔴 <a style='text-decoration:none' href='setpt.php?decred'>-</a> ".$jdat["ptA"]."pt <a style='text-decoration:none' href='setpt.php?incred'>+</a></h3>";
		echo "<h3>🔵 <a style='text-decoration:none' href='setpt.php?decblue'>-</a> ".$jdat["ptB"]."pt <a style='text-decoration:none' href='setpt.php?incblue'>+</a></h3>";
		echo "<h3><a href='reset.php'>REIMPOSTA</a></h3>";
		break;
	default:
		//umanaged
}

?>
</body>

<script>
var ts = <?php echo $jdat['lastwrite'];?>;

function myFunction() {
   var xmlHttp = new XMLHttpRequest();
   xmlHttp.open("GET", "./getupdate.php", true);
   xmlHttp.onload = function () {
       var tsnew = xmlHttp.responseText;
       if(tsnew!=ts) {
           console.log(tsnew);
           window.location.reload();
       }
   };
   xmlHttp.send();
}

setInterval(myFunction, 1000);
    
</script>

</html>
