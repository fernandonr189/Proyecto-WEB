<?php
    include 'connection.php';
    session_start();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT * FROM ADMIN_USER WHERE EMAIL = '$email' AND PASSWORD ='$password'");

    if(!$sql) {
        echo "Error, usuario no encontrado";
    }
    if($user = mysqli_fetch_assoc($sql)) {
        $_SESSION["admin_email"] = $email;
        $_SESSION["admin_name"] = $user["name"]." ".$user["last_name"];
        $_SESSION["admin_id"] = $user['id'];
        header("location: ../admin.php?search=");
    }

    $sql = mysqli_query($conn, "SELECT * FROM USERS WHERE EMAIL = '$email' AND PASSWORD ='$password'");
    if(!$sql) {
        echo "Error, usuario no encontrado";
    }
    if($user = mysqli_fetch_assoc($sql)) {
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $user["NAME"];
        $_SESSION["id"] = $user['ID'];
        header("location: ../index.php");
    }
    else {
        echo "Correo o contraseña incorrecto";
    }
?>