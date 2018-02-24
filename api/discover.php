<?php
    include 'config.php';

    // build socket and join multicast group
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_set_option($sock, IPPROTO_IP, MCAST_JOIN_GROUP, array(
        'group' => $config['multicast_ip'],
        'interface' => $config['multicast_interface'],
        )
    );
    socket_bind($sock, '0.0.0.0', $config['multicast_port']);
    // send discovery message
    socket_sendto($sock, $config['discovery_msg'], strlen( $config['discovery_msg']), 0, $config['multicast_ip'], $config['multicast_port']);


    // wait for a reply
    socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec"=> 0, "usec" => $config['usec_wait']));
    $bulbs = array();
    $sources = array();
    do {
        $len = 1023 ;
        $flags = 0 ;
        $recvStr = "";
        $from = "" ;
    //    socket_set_option($sock,IPPROTO_IP,MCAST_JOIN_GROUP,$grpparms);
        $res = socket_recvfrom($sock, $recvStr, $len, $flags, $from, $config['multicast_port']);
//        echo "Received " . $recvStr . " from " . $from ."\n";
        $lines = explode("\r\n", $recvStr);
        if (count($lines) > 0 && $lines[0] === "HTTP/1.1 200 OK") {
            unset($lines[0]);
            $headers = array();
            foreach($lines as $line) {
                if (empty($line)) continue;
//                echo strlen($line). ' ' .$line . "\n";
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
            $headers['ip'] = $from;
            if (!in_array($from, $sources)) {
                $sources[] = $from;
                $bulbs[] = $headers;
            }
        }
    } while(false !== $res);

    if (count($bulbs) === 0) {
        http_response_code(404);
    } else {
        echo json_encode($bulbs);
    }

    socket_close($sock) ;
