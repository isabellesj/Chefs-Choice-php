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
    <link href="/css/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/2471abcbe0.js" crossorigin="anonymous"></script>
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
    <h3>Chef-approved essentials for your table</h3>

    <section class="popular__products">
        <!-- Loopa alla produkter och SKAPA tr taggar -->
        <?php
        // $result = $dbContext->searchProducts($sortCol, $sortOrder, $q, null);
        // foreach ($result["data"] as $product) {
        foreach ($dbContext->getPopularProducts($sortCol, $sortOrder, $q) as $product) {
            echo "<div class='product__wrapper'><p><a href='product.php?id=$product->id'>$product->title</a><img class='product__img' src=$product->image></img></p><p>$product->categoryId</p><p>$product->price</p><button>BUY</button></div>";

        }
        ?>
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