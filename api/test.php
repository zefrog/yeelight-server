<?php

    include "config.php";

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($sock, '192.168.1.23', 55443);

        $data = json_encode(array(
            'id' => 123,
            'method' => 'set_name',
            'params' => ['Cuisine']
        )) . "\r\n";
        echo $data;

        socket_write($sock, $data, strlen($data));

$out = socket_read($sock, 2048);
echo $out;

socket_close($sock);
