<?php

try {
    $conn = new mysqli("localhost", "root", "", "hamsod");

    // Check connection
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    if ($conn) {
        $gateways = $conn->query("UPDATE available_products SET is_active=0 WHERE is_active=1;");
        /*
        while($gateway = $gateways->fetch_assoc()) {
            $gatewayId = $gateway["id"];
        }
        */
    }
} catch (Exception $exception) { // log exception
    echo $exception->getMessage().PHP_EOL;
}
