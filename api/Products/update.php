<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/Products.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$product = new Products($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set productID to update
    $product->productId = $data->productId;
    $product->productName = $data->productName;
    $product->productImage = $data->productImage;
    $product->productDescription = $data->productDescription;
    $product->productPrice = $data->productPrice;
    $product->productCode = $data->productCode;
    $product->productQuantity = $data->productQuantity;
    $product->createdDate = $data->createdDate;


// Update products
if($product->update()) {
    echo json_encode(
      $data
    );
} else {
    echo json_encode(
        array('message' => 'Products not Updated')
    );
}


