<?php

use Apex\Mercury\WebSocket\WsServer;
use Apex\Mercury\WebSocket\Server\ConnectionManager;
use Apex\Armor\Armor;

// Load autoload.php
require("./vendor/autoload.php");

// Start daemon, if needed
if (isset($argv[1]) && $argv[1] == '-d') { 
    echo "Starting web socket server...\n";
    exec("nohup php listen.php > nohup.out 2> nohup.err < /dev/null &");
    exit(0);
}

// Init Armor
$armor = new Armor(
    container_file: __DIR__ . '/config/container_armor.php'
);

// Init server
$server = new WsServer(
    admin_pass: 'admin12345', 
    armor: $armor
);

// Listen
$server->listen();

