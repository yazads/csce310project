<?php
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $connection = mysqli_connect($server_name, $user_name, $password);
    if (!$connection) {
    die("Failed ". mysqli_connect_error());
    }
    echo "Connection established successfully";
?>