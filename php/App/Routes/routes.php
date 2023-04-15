<?php

namespace App;

use App\Controller\GameController;

// require_once('../../vendor/autoload.php');

// use App\Controllers\ResourcesController;

// require_once __DIR__ . '/vendor/autoload.php';

// $klein = new \Klein\Klein();
$klein = new \Klein\Klein();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Authorization, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

// $klein->respond('GET', '/hello-world', function () {
//     return 'Hello World!';
// });

$klein->respond(['GET'], '/test', [new GameController(), 'test']);
$klein->respond(['GET'], '/init-game', [new GameController(), 'initGame']);
// $klein->respond(['GET'], '/get-ticket-random', [new GameController(), 'getTicketRandom']);
$klein->respond(['GET'], '/playing', [new GameController(), 'playing']);

$klein->dispatch();
