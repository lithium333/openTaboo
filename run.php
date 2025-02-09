<html>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<body>
<h1 style='text-align:center;'>openTaboo</h1>
<?php
$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);
switch($jdat["state"]) {
	case 0:
		header("Location: player.php");
		break;
	case 1:
		if(($jdat["players"][$_GET['id']-1])==null)
			header("Location: player.php");
		echo "<h2>Player: ".$jdat["players"][$_GET['id']-1]."</h2>\n";
		echo "<h2>Aspetta che il caposala dia il via...</h2>\n";
		echo "<div class='loaderbar'></div>\n";
		break;
	case 2:
		function prtcarta() {
			$jcartaraw = file_get_contents("carta.json");
			$jcartadat = json_decode($jcartaraw,true);
			echo "<div style='border:3px solid;width:180px;margin:0 auto;margin-top:32px;border-radius:12px;'>\n";
			echo "<h2 style='text-align:center;color:darkblue;' >".$jcartadat["parola"]."</h2>\n";
			foreach($jcartadat["vietato"] as $parolabandita)
				echo "<p style='text-align:center;color:darkorange;' >".$parolabandita."</p>\n";
			echo "</div>\n";
			
		}
		$playerid=$_GET['id']-1;
		$teamid=$playerid%2; // 0 red ; 1 blu
		$turnoteam=$jdat['turno']%2;
		echo "<h2>".$jdat["players"][$_GET['id']-1];
		if($teamid) {
			echo " 🔵 ";
		} else {
			echo " 🔴 ";
		}
		echo "[".$_GET['id']."]</h2>\n";
		//gestione turno
		if($playerid==$jdat['turno']) {
			echo "<h2>TURNO TUO!</h2>\n";
			prtcarta();
			//gestione carta e timer
		} else {
			if($teamid==$turnoteam) {
				echo "<h2>Turno del tuo team, INDOVINA ❓</h2>\n";
			} else {
				echo "<h2>Turno del team avversario, CONTROLLA 👀</h2>\n";
				echo "<div class='loaderbar'></div>\n";
				prtcarta();
			}
		}
	default:
		//unmanaged
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
setInterval(myFunction, 250);
</script>
<style>
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
</html>
