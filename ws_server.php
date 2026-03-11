<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ScadaServer implements MessageComponentInterface {
    protected $clients = [];

    public function __construct() {
        echo "WebSocket Server started\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = $conn;
        echo "\nClient connected: ID {$conn->resourceId}\n";
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->clients[$conn->resourceId]);
        echo "\nClient disconnected: ID {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "\nMessage received: $msg\n";

        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "\nError: {$e->getMessage()}\n";
        $conn->close();
    }

    public function broadcast($data) {
        foreach ($this->clients as $client) {
            $client->send($data);
        }
    }
}

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ScadaServer()
        )
    ),
    8090
);

$server->run();