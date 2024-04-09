<?php
require_once ("Models/Product.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");


$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$q = $_GET['q'] ?? "";
$pageNo = $_GET['pageNo'] ?? "1";
$pageSize = $_GET['pageSize'] ?? "20";
$categoryId = $_GET['categoryId'] ?? "";


$dbContext = new DBContext();
$urlModifier = new UrlModifier();
?>

<!DOCTYPE html>
<html lang="en">

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
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Chef's Choice</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Categorier</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            foreach ($dbContext->getAllCategories() as $category) {
                                echo "<li><a class='dropdown-item' href='#!'>$category->title</a></li> ";
                            }
                            ?>

                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#!">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Create account</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <?php
                // $hour = date('h');
                // if ($hour >= 9) {
                //             ?>
                // <h1 class="display-4 fw-bolder">Super shoppen</h1>
                //
                <?php
                // }
                ?>
                <p class="lead fw-normal text-white-50 mb-0">Handla massa onödigt hos oss!</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <select>
                <?php
                foreach ($dbContext->getAllCategories() as $category) {
                    echo "<option>$category->title</option> ";
                }

                //kan ev. tas bort sen
                ?>


            </select>
            <form method="GET">
                Search:
                <input type="text" name="q" value="<?php echo $q; ?>" />
                <?php echo $sortCol; ?>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name
                            <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-up-a-z"></i></a>
                            <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-down-z-a"></i></a>
                        </th>
                        <th>Category
                            <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-up-a-z"></i></a>

                            <a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-down-z-a"></i></a>
                        </th>
                        <th>Price
                            <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-up-a-z"></i></a>

                            <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-down-z-a"></i></a>
                        </th>
                        <th>Stock level
                            <a href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-up-a-z"></i></a>

                            <a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>"><i
                                    class="fa-solid fa-arrow-down-z-a"></i></a>
                        </th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Loopa alla produkter och SKAPA tr taggar -->
                    <?php
                    foreach ($dbContext->searchProducts($sortCol, $sortOrder, $q, $categoryId) as $product) {
                        if ($product->price > 20) {
                            echo "<tr><td>$product->title</td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";
                        } else {
                            echo "<tr class='table-info'><td>$product->title</td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>