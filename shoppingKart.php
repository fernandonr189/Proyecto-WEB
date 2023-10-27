<?php
	include 'php/connection.php';
    session_start();
    @$user = $_SESSION['name'];
    @$id = $_SESSION['id'];
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

	$sql = "SELECT p.NAME, p.IMAGE, p.PRICE, sum(p.PRICE), p.DESCRIPTION, sum(s.AMOUNT), s.ID, s.PRODUCT_ID FROM PRODUCTS p, SHOPPING_CART s, USERS u WHERE s.PRODUCT_ID = p.ID AND s.USER_ID = u.ID AND u.ID = $id GROUP BY p.name";
	$result = $conn->query($sql);
    $concepts = array();

	//$sql_price = "SELECT sum(p.price) FROM products p, shopping_kart s, user_login_info u WHERE s.product_id = p.id AND s.user_id = u.id AND u.id = $id";
	//$result_price = $conn->query($sql_price);

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
        <div class ="row g-0">
            <div class ="col-md-8">
                <section class="py-5">
                    <div class="container px-4 px-lg-5 mt-5">
                        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                            <?php
                                $price = 0;
                                while($rows = $result->fetch_assoc()) {
                                    $price = $price + $rows['sum(p.PRICE)'];
                                    array_push($concepts, $rows['NAME'] . " x" . $rows['sum(s.AMOUNT)'] . " " . "$" . $rows['sum(p.PRICE)'] . " ");
                                    echo "
                                    <div class=\"col mb-5\">
                                        <div class=\"card h-100\">
                                            <!-- Product image-->
                                            <img class=\"card-img-top p-5 \" src=\"php/" . $rows['IMAGE'] . "\" alt=\"...\" />
                                            <!-- Product details-->
                                            <div class=\"card-body p-4\">
                                                <div class=\"text-center\">
                                                    <!-- Product name-->
                                                    <a href=\"product.php" . "?product_id=" . $rows['PRODUCT_ID'] . " \" class=\"link-dark text-decoration-none\">
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
                                                    " . $rows['sum(s.AMOUNT)'] . "x$" .$rows['PRICE'] . "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <div class="p-5">
                    <div class="container p-4 m-1 bg-light  rounded">
                        <div>
                            <?php
                                foreach($concepts as $concept) {
                                    echo "
                                    <div class=\"my-2\">
                                        " . $concept . "
                                    </div>";
                                }
                                echo "<hr>";
                                echo "Total: $" . $price;
                            ?>
                            <div class="my-4">
                                <form action="php/logout.php" class="p-1">
                                    <button class="btn btn-outline-dark" type="submit">
                                        <i class="bi bi-bag me-1"> Comprar carrito</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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
