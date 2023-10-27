<?php

    include 'connection.php';

    $id = mysqli_query($conn, "SELECT ID FROM PRODUCTS ORDER BY ID DESC limit 1");
    while ($row = $id->fetch_assoc()) {
        $lastId = intval($row['ID']) + 1;
    }
    if(intval($lastId) < 1 || !isset($lastId)) {
        $lastId = 1;
    }

    $target_dir = "images/";
    $target_file = $target_dir . $lastId.".png";
    $uploadOk = 1;

    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $target_file;
    $type = $_POST['type'];


    $sql = mysqli_query($conn, "INSERT INTO PRODUCTS (NAME, DESCRIPTION, PRICE, IMAGE, TYPE)
    VALUES ('$name', '$description', '$price', '$image', '$type')");

    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
    }
    else {
        echo "Sorry, there was an error uploading your file.";
    }

    if ($sql -> connect_errno){
        die("Error al agregar" . $sql -> connect_errno);
    } else {
        echo "Agregado correctamente";
        header("location: ../admin/addProduct.php");
    }

?>