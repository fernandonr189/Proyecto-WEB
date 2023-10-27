<?php
	include '../php/connection.php';
    session_start();
    @$user = $_SESSION['admin_name'];
    @$id = $_SESSION['admin_id'];
    @$productId = $_GET['productId'];
    @$editing = $_GET['editing'];
    $logout_button = "
    <form action=\"../php/logout.php\" class=\"p-1\">
        <button class=\"btn btn-outline-dark\" type=\"submit\">
            <i class=\"bi-door-open me-1\"> Logout</i>
        </button>
    </form>";
    if(!isset($user)) {
        header("location: ../index.php");
    }

    if(isset($editing)) {
        $sql = "SELECT * FROM PRODUCTS WHERE ID = '$productId'";
        $result = $conn->query($sql);
        $conn->close();
        $product = $result->fetch_assoc();
    }
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="../products.php">Products</a></li>
                    </ul>
                    <?php
                        echo $logout_button;
                    ?>
                </div>
            </div>
        </nav>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src=<?php if(isset($editing)) {echo "\"../php/" . $product['IMAGE'] . "\""; } else { echo "\"https://dummyimage.com/600x700/dee2e6/6c757d.jpg\""; }?> alt="..." /></div>
                    <div class="col-md-6">
                        <?php
                            if(isset($editing)) {
                                echo "
                                <form action=\"../php/modifyProduct.php\", method=\"post\" enctype=\"multipart/form-data\">
                                    <input hidden=true name=\"id\" type=\"text\" class=\"form-control\" id=\"id\" value=\"" . $product['ID'] . "\">
                                    <div class=\"mb-3\">
                                        <label for=\"name\" class=\"form-label\">Name</label>
                                        <input name=\"name\" type=\"text\" class=\"form-control\" id=\"name\" value=\"" . $product['NAME'] . "\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"description\" class=\"form-label\">Description</label>
                                        <input name=\"description\" type=\"text\" class=\"form-control\" id=\"description\" value=\"" . $product['DESCRIPTION'] . "\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"price\" class=\"form-label\">Price</label>
                                        <input name=\"price\" type=\"text\" class=\"form-control\" id=\"price\" value=\"" . $product['PRICE'] . "\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"image\" class=\"form-label\">Image</label>
                                        <input type=\"file\" name=\"image\" id=\"image\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"type\" class=\"form-label\">Type</label>
                                        <input name=\"type\" type=\"text\" class=\"form-control\" id=\"type\" value=\"" . $product['TYPE'] . "\">
                                    </div>
                                        <button type=\"submit\" class=\"btn btn-outline-dark\">Submit</button>
                                </form>";
                            }
                            else {
                                echo "
                                <form action=\"../php/addProduct.php\", method=\"post\" enctype=\"multipart/form-data\">
                                    <div class=\"mb-3\">
                                        <label for=\"name\" class=\"form-label\">Name</label>
                                        <input name=\"name\" type=\"text\" class=\"form-control\" id=\"name\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"description\" class=\"form-label\">Description</label>
                                        <input name=\"description\" type=\"text\" class=\"form-control\" id=\"description\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"price\" class=\"form-label\">Price</label>
                                        <input name=\"price\" type=\"text\" class=\"form-control\" id=\"price\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"image\" class=\"form-label\">Image</label>
                                        <input type=\"file\" name=\"image\" id=\"image\">
                                    </div>
                                    <div class=\"mb-3\">
                                        <label for=\"type\" class=\"form-label\">Type</label>
                                        <input name=\"type\" type=\"text\" class=\"form-control\" id=\"type\">
                                    </div>
                                        <button type=\"submit\" class=\"btn btn-outline-dark\">Submit</button>
                                </form>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        
        <!-- Footer-->
        <footer class="footer mt-auto py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
