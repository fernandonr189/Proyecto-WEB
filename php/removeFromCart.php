<?php
    include 'connection.php';
    session_start();

    $id = $_SESSION['id'];
    $productId = $_GET['productId'];

    $sql = mysqli_query($conn, "DELETE FROM SHOPPING_CART WHERE PRODUCT_ID = '$productId' AND USER_ID = '$id'");

    if ($sql -> connect_errno){
        die("Error al eliminar" . $sql -> connect_errno);
    } else {
        echo "Eliminado correctamente";
        header("location: ../shoppingKart.php");
    }
?>