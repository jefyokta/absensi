<?php

use Swoole\Http\Server;
use Swoole\Coroutine;

$server = new Server("0.0.0.0", 9501);

$server->on("start", function ($server) {
    echo "Swoole HTTP Server dimulai di http://127.0.0.1:9501\n";
});

$server->on("request", function ($request, $response) use($server) {

    $time = microtime(true);

    Coroutine::create(function () use ($response) {
        Coroutine::sleep(2);
        $response->header("Content-Type", "text/plain");
    });

    Coroutine::create(function () use ($response, $time,$server) {
        Coroutine::sleep(2);
        $response->end("Halo dari Swoole setelah tugas asynchronous selesai!");
        echo "Took " . (microtime(true) - $time) . " seconds\n";
        $server->reload();
    });
});

$server->on("AfterReload",function(){
    echo "reloaded\n";
});

$server->start();
