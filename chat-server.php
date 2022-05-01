<?php
    use Ratchet\Server\IoServer;
    use Ratchet\Http\HttpServer;
    use Ratchet\WebSocket\WsServer;
    use SimpleSocket\EventsSocket;

    require 'vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new EventsSocket()
            )
        ),
        8080
    );

    $server->run();