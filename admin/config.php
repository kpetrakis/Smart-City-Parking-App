<?php

    $SERVER_NAME = "localhost";
    $USER_NAME = "root";
    $PASSWORD = "";
    $DB_NAME = "test";

    $conn = new mysqli($SERVER_NAME, $USER_NAME, $PASSWORD, $DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("SET CHARACTER SET 'utf8'");

?>