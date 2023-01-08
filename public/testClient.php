<?php
error_reporting(E_ALL);
set_time_limit(0);
echo ' '.PHP_EOL;

echo '<h2>TCP/IP Contention Test</h2>'.PHP_EOL;

$host = '192.168.56.101';
$port = '9999';

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

echo 'There is Tcp socket connection test'.PHP_EOL;
$conRes  = socket_connect($sock, $host,$port);
if ($conRes < 0) {
    echo 'The Tcp Socket connection is fail.'.PHP_EOL;
}
else {
    echo 'The Tcp Socket connection is successful. We can send message to each other.'.PHP_EOL;
}

$in = 'There is Tcp socket send message test';
$out = '';

$writeRes = socket_write($sock, $in, strlen($in));
if (!$writeRes) {
    echo 'Socket send message is fail.'.PHP_EOL;
}
else {
    echo 'Socket send message is successful.'.PHP_EOL;
    echo "The message is : ' $in ' to server.".PHP_EOL;
}

while ($out = socket_read($sock, 8192)) {
    echo 'Read the message for server'.PHP_EOL;
    echo "The message is : ' $out ' from server.".PHP_EOL;
}

echo 'Close the Tcp Socket connect.'.PHP_EOL;
socket_close($sock);
