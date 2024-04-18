<?php
require_once ("Models/Database.php");
require_once ("Utils/UrlModifier.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");
require_once ("Pages/layout/categories.php");

$id = $_GET['id'] ?? "";
$q = $_GET['q'] ?? "";


$dbContext = new DBContext();
$urlModifier = new UrlModifier();

$product = $dbContext->getProduct($id);
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
    layout_navigation($dbContext);
    layout_categories($dbContext, $q);
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