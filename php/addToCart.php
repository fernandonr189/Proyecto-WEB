<?php
include 'connection.php';
session_start();

$id = $_SESSION['id'];
$productId = $_GET['productId'];
$amount = $_GET['amount'];

$sql = mysqli_query($conn, "INSERT INTO SHOPPING_CART (USER_ID, PRODUCT_ID, AMOUNT)
VALUES ('$id', '$productId', '$amount')");

if ($sql -> connect_errno){
    die("Error al agregar" . $sql -> connect_errno);
} else {
    echo "Agregado correctamente";
    header("location: /products.php");
}
?>