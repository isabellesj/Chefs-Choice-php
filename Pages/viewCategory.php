<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");

$sortCol = $_GET['sortCol'] ?? "";
$q = $_GET['q'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$categoryId = $_GET['id'] ?? "";
$pageSize = $_GET['pageSize'] ?? "10";
$pageNo = $_GET['pageNo'] ?? "1";
$dbContext = new DBContext();
$urlModifier = new UrlModifier(); //??
$category = $dbContext->getCategory($categoryId);
$id = $_GET['id'] ?? "";

// $id = $_GET['id'] ?? "";

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
    <?php
    layout_navigation($dbContext, $sortCol, $q);
    ?>

    <table>
        <thead>
            <tr>
                <th>Name
                    <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>
                    <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Category
                    <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>>"><i
                            class="fa-solid fa-arrow-up"></i></a>

                    <a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Price
                    <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>

                    <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
                <th>Stock level
                    <a href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-up"></i></a>

                    <a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                            class="fa-solid fa-arrow-down"></i></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $dbContext->searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo, $pageSize);
            foreach ($result["data"] as $product) {
                echo "<tr><td><a href='viewCategory?id=$product->id'>$product->title</a></td></td><td>$product->categoryId</td><td>$product->price</td><td>$product->stockLevel</td><td>";
            }
            ?>
        </tbody>


</body>