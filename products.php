<?php
    include 'php/connection.php';
    session_start();
    @$user = $_SESSION['name'];
    @$id = $_SESSION['id'];
    @$admin_id = $_SESSION['admin_id'];
    @$admin_name = $_SESSION['admin_name'];
    $shopping_cart_button = "
    <form action=\"shoppingKart.php\" class=\"p-1\">
        <button class=\"btn btn-outline-dark\" type=\"submit\">
            <i class=\"bi-cart-fill me-1\"> Cart</i>
        </button>
    </form>";
    $login_button = "
    <form action=\"login.php\" class=\"p-1\">
        <button class=\"btn btn-outline-dark\" type=\"submit\">
            <i class=\"bi-door-open me-1\"> Login</i>
        </button>
    </form>";
    $logout_button = "
    <form action=\"php/logout.php\" class=\"p-1\">
        <button class=\"btn btn-outline-dark\" type=\"submit\">
            <i class=\"bi-door-open me-1\"> Logout</i>
        </button>
    </form>";
    $add_product_button = "
    <form action=\"admin/addProduct.php\" class=\"p-1\">
        <button class=\"btn btn-outline-dark\" type=\"submit\">
            <i class=\"bi bi-plus-circle me-1\"> Add product</i>
        </button>
    </form>";

    $sql = "SELECT * FROM PRODUCTS ORDER BY ID DESC";
    $result = $conn->query($sql);
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    </ul>
                    <?php
                        if(isset($user)) {
                            echo $shopping_cart_button;
                            echo $logout_button;
                        }
                        else {
                            echo $login_button;
                        }
                    ?>
                </div>
            </div>
        </nav>

        <!-- Section-->
        <div class="d-flex align-items-center justify-content-center m-5">
            <?php
                if(isset($admin_id)) {
                    echo $add_product_button;
                }
            ?>
        </div>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                        while($rows = $result->fetch_assoc()) {
                            echo "
                            <div class=\"col mb-5\">
                                <div class=\"card h-100\">
                                    <!-- Product image-->
                                    <img class=\"card-img-top p-5 \" src=\"php/" . $rows['IMAGE'] . "\" alt=\"...\" />
                                    <!-- Product details-->
                                    <div class=\"card-body p-4\">
                                        <div class=\"text-center\">
                                            <!-- Product name-->
                                            <a href=\"product.php" . "?product_id=" . $rows['ID'] . " \" class=\"link-dark text-decoration-none\">
                                                <h5 class=\"fw-bolder\">" . $rows['NAME'] . "</h5>
                                            </a>
                                            <!-- Product reviews-->
                                            <div class=\"d-flex justify-content-center small text-warning mb-2\">
                                                <div class=\"bi-star-fill\"></div>
                                                <div class=\"bi-star-fill\"></div>
                                                <div class=\"bi-star-fill\"></div>
                                                <div class=\"bi-star-fill\"></div>
                                                <div class=\"bi-star-fill\"></div>
                                            </div>
                                            <!-- Product price-->
                                            " . $rows['PRICE'] . "
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class=\"card-footer p-4 pt-0 border-top-0 bg-transparent\">
                                        <div class=\"text-center\"><a class=\"btn btn-outline-dark mt-auto\" href=\"php/addToCart.php?productId=" . $rows['ID'] . "&amount=1" . "\">Add to cart</a></div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </section>
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
