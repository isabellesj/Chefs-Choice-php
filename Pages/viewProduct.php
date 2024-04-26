<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Pages/layout/categories.php");
require_once ("Functions/doctype.php");

$id = $_GET['id'] ?? "";
$q = $_GET['q'] ?? "";
$categoryId = $_GET['id'] ?? "";


$dbContext = new DBContext();
$urlModifier = new UrlModifier();

$product = $dbContext->getProduct($id);

doctype();
?>

<body>
    <?php
    layout_navigation($dbContext);
    layout_categories($dbContext, $q, $categoryId);
    ?>

    <main class="viewproduct__wrapper">
        <img class="viewproduct__img" src="  <?php echo $product->image ?>" alt="  <?php echo $product->title ?>"></img>
        <h2 class="viewproduct__title">
            <?php echo $product->title ?>
        </h2>
        <p>
            <?php echo "Price: $product->price kr" ?>
        </p>
        <button class="viewproduct__buy__button">Add to cart</button>
    </main>

    <?php
    layout_footer();
    ?>
</body>