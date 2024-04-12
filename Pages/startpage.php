<?php
require_once ("Models/Product.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/header.php");


$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET['sortCol'] ?? "";
$q = $_GET['q'] ?? "";
$pageNo = $_GET['pageNo'] ?? "1";
$pageSize = $_GET['pageSize'] ?? "20";
$categoryId = $_GET['categoryId'] ?? "";
$stockLevel = $_GET['stockLevel'] ?? "";


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
    <title>Chef's Choice</title>
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
    <link href="/css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php
    layout_navigation($dbContext, $sortCol, $q)
        ?>
    <!-- Header-->
    <?php
    layout_header();
    ?>
    <!-- Section-->
    <section class="table__wrapper">
        <h3>Chef-approved essentials for your table</h3>

        <table>
            <thead>
                <tr>
                    <th>Name
                        <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-up"></i></a>
                        <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                    <th>Category
                        <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-up"></i></a>

                        <a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                    <th>Price
                        <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-up"></i></a>

                        <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                    <th>Stock level
                        <a href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-up"></i></a>

                        <a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>"><i
                                class="fa-solid fa-arrow-down"></i></a>
                    </th>
                </tr>
            </thead>

            <tbody>
                <!-- Loopa alla produkter och SKAPA tr taggar -->
                <?php
                // $result = $dbContext->searchProducts($sortCol, $sortOrder, $q, null);
                // foreach ($result["data"] as $product) {
                foreach ($dbContext->getPopularProducts() as $product) {
                    echo "<tr><td><a href='product.php?id=$product->id'>$product->title</a></td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td></tr>";

                }
                ?>
            </tbody>
        </table>

    </section>
    <!-- Footer-->
    <footer>
        <div class="container">
            <p>Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>