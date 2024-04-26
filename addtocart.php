<?php
require_once ("Models/Database.php");
$id = $_GET['id'] ?? "";


$dbContext = new DBContext();
//Köra en insert into shoppingcartitem
$quantity = $dbContext->addToCart($id);

// $
echo json_encode($quantity);

?>