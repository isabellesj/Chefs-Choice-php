<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Pages/layout/categories.php");
require_once ("Functions/showProducts.php");
require_once ("Functions/oneOf.php");
require_once ("Functions/doctype.php");

$sortCol = $_GET['sortCol'] ?? "";
$sortCol = oneOf($sortCol, ["title", "categoryId", "price", "stockLevel"], "id");
$q = $_GET['q'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "";
$sortOrder = $sortOrder == 'desc' ? 'desc' : 'asc';
$categoryId = $_GET['id'] ?? "";
$pageSize = intval($_GET['pageSize'] ?? "5");
$pageNo = intval($_GET['pageNo'] ?? "1");
$dbContext = new DBContext();
$urlModifier = new UrlModifier(); //??
$category = $dbContext->getCategory($categoryId);
$id = $_GET['id'] ?? "";


doctype();
?>

<body>
    <script>
        async function addToCart(id) {
            const quantity = await ((await fetch(`/addtocart?id=${id}`)).text())
            console.log(quantity)
            document.getElementById("quantity").innerText = quantity
        }
    </script>

    <?php
    layout_navigation($dbContext);
    layout_categories($dbContext, $q, $categoryId);
    ?>

    <article class="filter">
        <p>Name <a href="?sortCol=title&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                    id='filter__icon' class="fa-solid fa-arrow-up"></i></a>
            <a href="?sortCol=title&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i id='filter__icon'
                    class="fa-solid fa-arrow-down"></i></a>
        </p>
        <p>Price
            <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i id='filter__icon'
                    class="fa-solid fa-arrow-up"></i></a>

            <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i id='filter__icon'
                    class="fa-solid fa-arrow-down"></i></a>
        </p>
        <p>Stock level
            <a href="?sortCol=stockLevel&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                    id='filter__icon' class="fa-solid fa-arrow-up"></i></a>

            <a href="?sortCol=stockLevel&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i
                    id='filter__icon' class="fa-solid fa-arrow-down"></i></a>
        </p>
    </article>
    <section class="category__products">
        <?php

        $result = $dbContext->searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo, $pageSize);
        foreach ($result["data"] as $product) {
            echo showProducts($product);
        }

        ?>
    </section>

    <?php
    layout_footer()
        ?>
</body>