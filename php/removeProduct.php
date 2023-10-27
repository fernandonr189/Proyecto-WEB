<?php
    include 'connection.php';
    session_start();
    $productId = $_GET['productId'];

    $sql = mysqli_query($conn, "DELETE FROM PRODUCTS WHERE ID = '$productId'");

    $sql_cart = mysqli_query($conn, "DELETE FROM SHOPPING_CART WHERE PRODUCT_ID = '$productId'");

    if ($sql -> connect_errno){
        die("Error al eliminar" . $sql -> connect_errno);
    } else {
        echo "Eliminado correctamente";
        header("location: ../products.php");
    }
?>