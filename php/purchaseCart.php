<?php
    include 'connection.php';
    session_start();

    $id = $_SESSION['id'];

    $sql = mysqli_query($conn, "DELETE FROM SHOPPING_CART WHERE USER_ID = '$id'");

    if ($sql -> connect_errno){
        die("Error al eliminar" . $sql -> connect_errno);
    } else {
        echo "Eliminado correctamente";
        header("location: ../index.php");
    }
?>