<?php declare(strict_types=1);

use Workerman\Worker;
use Workerman\Protocols\Http\Request;
use Workerman\Connection\TcpConnection;

$autoloader = require_once __DIR__ . '/vendor/autoload.php';

// $worker = new Worker('https://0.0.0.0:443', [
//     'ssl' => [
//         'local_cert' => getenv('SSL_LOCAL_CERT'),
//         'local_pk' => getenv('SSL_LOCAL_KEY'),
//         'verify_peer' => getenv('SSL_VERIFY_PEER'),
//     ],
// ]);
// $worker->transport = 'ssl';

$worker = new Worker('http://0.0.0.0:80');
$worker->count = 1;

// Emitted when data received
$worker->onMessage = function (TcpConnection $connection, Request $request) {
    var_dump(func_get_args());
    die;
    //$request->get();
    //$request->post();
    //$request->header();
    //$request->cookie();
    //$request->session();
    //$request->uri();
    //$request->path();
    //$request->method();

    // Send data to client
    $connection->send("Hello World");
};

// Run all workers
Worker::runAll();
