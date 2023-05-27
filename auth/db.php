<?php

try {
    $mysqli = new mysqli('127.0.0.1', 'web', '123', 'ticketsystem');
    
    if ($mysqli->connect_errno) {
        throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
} catch (Exception $e) {
    // Handle the exception
    echo 'Caught exception: ' . $e->getMessage();
}

?>
