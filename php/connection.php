<?php
    $servername = "localhost";
    $user = "cyfer";
    $password = "123";

    $conn = new mysqli($servername, $user, $password, "cyfer_user_database");

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>