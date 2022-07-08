<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/Products.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate users object
$products = new Products($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$products->productName = $data->productName;
$products->productImage = $data->productImage;
$products->productDescription = $data->productDescription;
$products->productPrice = $data->productPrice;
$products->productCode = $data->productCode;
$products->productQuantity = $data->productQuantity;
$products->createdDate = $data->createdDate;


// Create user
if($products->create())
{
    echo json_encode(
        $data
    );
}
else
{
    echo json_encode(
        array('message' => 'Use Not Created')
    );
}

