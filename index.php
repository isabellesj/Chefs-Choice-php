<?php
// globala initieringar !
require_once (dirname(__FILE__) . "/Utils/Router.php");
require_once ("vendor/autoload.php");

// $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/Pages/startpage.php';
});

// $router->addRoute('/viewProduct', function () {
//     require __DIR__ . '/Pages/viewProduct.php';
// });

// $router->addRoute('/newproduct', function () {
//     require (__DIR__ . '/Pages/newproduct.php');
// });


$router->addRoute('/viewCategory', function () {
    require __DIR__ . '/Pages/viewCategory.php';
});

$router->addRoute('/allProducts', function () {
    require __DIR__ . '/Pages/allProducts.php';
});

// $router->addRoute('/input', function () {
//     require __DIR__ . '/Pages/form.php';
// });

$router->dispatch();
?>