<?php
// According to yeelight developer specifications http://www.yeelight.com/download/Yeelight_Inter-Operation_Spec.pdf
// Just configure the multicast interface accorgind to your configuration
$config = array(
    'multicast_interface' => 'eth0',
    'multicast_port' => 1982,
    'multicast_ip' => '239.255.255.250',
    'discovery_msg' => "M-SEARCH * HTTP/1.1\r\nHOST: 239.255.255.250:1982\r\nMAN: \"ssdp:discover\"\r\nST: wifi_bulb\r\n",
    'tcp_port' => 55443,
    // you might have to set this higher if the network is slow (1usec is 1/1000000 of a second).
    'usec_wait' => 300000 // 300ms or 0.3s
);
