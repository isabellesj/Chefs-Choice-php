<?php
require_once ("Models/Product.php");
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/categories.php");
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/footer.php");
require_once ("Functions/showProducts.php");
require_once ("Functions/oneOf.php");
require_once ("Functions/doctype.php");


$sortOrder = $_GET['sortOrder'] ?? "";
$sortOrder = $sortOrder == 'desc' ? 'desc' : 'asc';
$sortCol = $_GET['sortCol'] ?? "";
$sortCol = oneOf($sortCol, ["title", "categoryId", "price", "stockLevel"], "id");
$q = $_GET['q'] ?? "";
$pageSize = intval($_GET['pageSize'] ?? "5");
$pageNo = intval($_GET['pageNo'] ?? "1");
$categoryId = $_GET['categoryId'] ?? "";
$stockLevel = $_GET['stockLevel'] ?? "";


$dbContext = new DBContext();
$urlModifier = new UrlModifier();

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
    layout_header();
    ?>

    <h3 class="startpage__title">Chef-approved essentials for your table</h3>

    <section class="popular__products">
        <?php
        foreach ($dbContext->getPopularProducts($sortCol, $sortOrder, $q) as $product) {
            echo showProducts($product);
        }
        ?>
    </section>
    <!-- Footer-->
    <?php
    layout_footer();
    ?>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>