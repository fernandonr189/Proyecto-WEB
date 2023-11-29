<?php
    $servername = "www.cyferdb.com";
    $user = "example_user";
    $password = "password";
    $conn = new mysqli($servername, $user, $password, "cyfer_user_database_2");

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>