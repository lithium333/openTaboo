<html>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<body>
<h1 style='text-align:center;'>openTaboo</h1>
<?php

$jraw = file_get_contents("game.json");
$jdat = json_decode($jraw,true);

// 0: sby, 1: players adding, 2:running
switch($jdat["state"]) {
	case 0:
		echo "<h2>Attendere che il caposala imposti i parametri...</h2>";
		echo "<div class='loaderbar'></div>\n";
		break;
	case 1:
		echo "<form action='join.php' method='get'>\n";
		echo "<h2>Scegli il tuo nome:</h2>\n";
		echo "<input type='textbox' name='nick' id='nick'>\n";
		echo "<h2>Scegli il tuo slot:</h2>\n";
		for($i=0;$i<$jdat["nplayers"];$i++) {
			if($jdat["players"][$i]===null) {
				echo "<h3><input type='radio' name='slot' id='slot' value='".($i+1)."'>";
				if($i%2)
					echo "SLOT ".($i+1)." 🔵</h3>";
				else
					echo "SLOT ".($i+1)." 🔴</h3>";
			}
		}
		echo "<br><input type='submit' value='PROCEDI'/>\n";
		echo "</form>\n";
		break;
	case 2:
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
