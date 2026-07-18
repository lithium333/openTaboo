<?php

ob_end_clean(); // disable default buffer

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // disable caching
header('Connection: keep-alive');

//set_time_limit(0);



include "core.php";

while(true) {
    gamedataRead(); // VARIABLE : $jdat
    echo "data:".$jdat['lastwrite']."\n\n"; // SEND TIMESTAMP LAST CHANGE
    flush();
    usleep(100000); // 100ms delay
    if(connection_aborted()) exit();
}

?>
