<?php
$conn = require __DIR__ . '/db_connect.php';
if($conn instanceof mysqli){
    echo "Database Connection Success\n";
}else{
    echo "Database Connection Failed\n";
}

require 'vendor/autoload.php';
use WebSocket\Client;

$lastStatus = []; // cache status per id

try{
    $client = new Client("ws://localhost:8090");
    $client->send("init connection");
    echo "WS Connection Success\n";
} catch(Exception $e){
    echo "WS Connection Failed: " . $e->getMessage() . "\n";
    exit(1);
}

while(true){
    $result = $conn->query(
        "SELECT id,machine_name,machine_status,last_update FROM status_test"
    );

    if($result === false){
        echo "DB Query Error: " . $conn->error . "\n";
        continue;
    }

    $changedRows = [];

    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $status = $row['machine_status'];

        if(!isset($lastStatus[$id]) || $lastStatus[$id] !== $status){
            $changedRows[$id] = $row;
            $lastStatus[$id] = $status;
        }
    }

    if(!empty($changedRows)){
        $payload = json_encode(array_values($changedRows));
        try{
            $client->send($payload);
            echo "Data Changed: " . count($changedRows) . "\n";
        } catch(Exception $e){
            echo "WS Send Error: " . $e->getMessage() . "\n";
        }
    }

    usleep(200000); // 200 ms
}