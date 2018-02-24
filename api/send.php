<?php

    include "config.php";

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($sock, $_POST['ip'], $config['tcp_port']);
    $params = $_POST['params'];
    if ($_POST['method'] === 'set_scene') {
        $params[1] = intval($params[1]);
        $params[2] = intval($params[2]);
//        $params[3] = intval($params[3]);
    }
        $data = json_encode(array(
            'id' => 1,
            'method' => $_POST['method'],
            'params' => $params
        )) . "\r\n";

        socket_write($sock, $data, strlen($data));

$out = socket_read($sock, 2048);
echo $out;
socket_close($sock);

