<?php

    include 'connection.php';

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "INSERT INTO USERS (EMAIL, NAME, PASSWORD)
    VALUES ('$email', '$name" . " " . "$lastname', '$password')");



    if ($sql -> connect_errno){
        die("Error al registrar" . $sql -> connect_errno);
    } else {
        echo "Registrado correctamente";
        header("location: /index.php");
    }

?>