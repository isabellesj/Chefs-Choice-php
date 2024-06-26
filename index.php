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

$router->addRoute('/viewCategory', function () {
    require __DIR__ . '/Pages/viewCategory.php';
});

$router->addRoute('/allProducts', function () {
    require __DIR__ . '/Pages/allProducts.php';
});

$router->addRoute('/viewProduct', function () {
    require __DIR__ . '/Pages/viewProduct.php';
});

$router->addRoute('/user/login', function () {
    require __DIR__ . '/Pages/users/login.php';
});

$router->addRoute('/user/logout', function () {
    require __DIR__ . '/Pages/users/logout.php';
});

$router->addRoute('/user/register', function () {
    require __DIR__ . '/Pages/users/register.php';
});

$router->addRoute('/user/verify_email', function () {
    require __DIR__ . '/Pages/users/verify_email.php';
});

$router->addRoute('/user/reset_password', function () {
    require __DIR__ . '/Pages/users/reset_password.php';
});

$router->addRoute('/user/forgotpassword', function () {
    require __DIR__ . '/Pages/users/forgotpassword.php';
});

$router->addRoute('/addtocart', function () {
    require __DIR__ . '/addtocart.php';
});

$router->dispatch();
?>