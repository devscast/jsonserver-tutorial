<?php

use Devscast\Server;

require(__DIR__ . "/vendor/autoload.php");

$server = new Server();
$route = mb_strtolower($_SERVER['REQUEST_URI']);
$method = mb_strtoupper($_SERVER['REQUEST_METHOD']);

// session will be use to simulate database storage
if (session_status() === PHP_SESSION_NONE) {
    session_name("devscast-jsonplaceholder");
    session_start();
}

$method === "OPTIONS" ?
    $server->handleOptionRequest() :
    $server->handleRequest($route, $method);
