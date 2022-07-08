<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Set ID to update
$product->productId = $data->productId;

// Delete post
if($product->delete()) {
    echo json_encode(
        array('message' => 'Product Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Product Not Deleted')
    );
}
