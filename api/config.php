<?php
$config = array(
    'multicast_interface' => 'eth0',
    'multicast_port' => 1982,
    'multicast_ip' => '239.255.255.250',
    'discovery_msg' => "M-SEARCH * HTTP/1.1\r\nHOST: 239.255.255.250:1982\r\nMAN: \"ssdp:discover\"\r\nST: wifi_bulb\r\n",
    'tcp_port' => 55443,
    'usec_wait' => 300000 // 300ms or 0.3s
);
