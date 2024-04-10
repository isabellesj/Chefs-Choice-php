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
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <?php
    layout_navigation($dbContext)
        ?>
    <!-- Header-->
    <?php
    layout_header();
    ?>
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