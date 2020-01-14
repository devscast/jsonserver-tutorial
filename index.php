<?php

use Devscast\Server;

require(__DIR__ . "/vendor/autoload.php");

$server = new Server();
$route = mb_strtolower($_SERVER['REQUEST_URI']);
$method = mb_strtoupper($_SERVER['REQUEST_METHOD']);

$method === "OPTIONS" ?
    $server->handleOptionRequest() :
    $server->handleRequest($route, $method);
