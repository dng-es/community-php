<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

//$time = date('r');
//echo "data: The server time is8: {$time}\n\n";
//echo "event: usermsg2\n\n";
echo "data: Hola2444 claudio\n";
echo "data: y más Hola23\n\n";
echo "id: 123456549923\n\n";

ob_flush();
flush();
?> 