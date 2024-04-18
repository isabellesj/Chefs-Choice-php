<?php
require_once ("Models/Database.php");

$dbContext = new DBContext();

require 'vendor/autoload.php';
require_once ('Models/Database.php');
require_once ("Pages/layout/header.php");
require_once ("Pages/layout/navigation.php");
require_once ("Pages/layout/footer.php");


$dbContext->getUsersDatabase()->getAuth()->logOut();
header('Location: /');
exit;