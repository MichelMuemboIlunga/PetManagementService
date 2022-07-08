<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/Products.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate  products object
$product = new Products($db);

// Get ID
$product->productId = isset($_GET['productId']) ? $_GET['productId'] : die();

// GET Products
$product->getProductById();

// create array

$product_item = array(
    'productId' => $product->productId,
    'productName' => $product->productName,
    'productImage' => $product->productImage,
    'productDescription' => $product->productDescription,
    'productPrice' => $product->productPrice,
    'productCode' => $product->productCode,
    'productQuantity' => $product->productQuantity,
    'createdDate' => $product->createdDate

);

// Make json
print_r(json_encode($product_item));
