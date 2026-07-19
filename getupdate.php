<?php

ob_end_clean(); // disable default buffer

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // disable caching
header('Connection: keep-alive');

//set_time_limit(0);

include "core.php";

$lastts=-1;

while(true) {
    gamedataRead(); // VARIABLE : $jdat
    if($lastts!=$jdat['lastwrite'])
        echo "data:".$jdat['lastwrite']."\n\n"; // SEND TIMESTAMP LAST CHANGE
    $lastts=$jdat['lastwrite'];
    flush();
    usleep(100000); // 100ms delay
    if(connection_aborted()) exit();
}

?>
