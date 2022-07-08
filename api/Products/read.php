<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/Products.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate  Products object
$products = new Products($db);

// user query
$result = $products->getAll();

// get row count
$num = $result->rowCount();

// check if any user
if($num > 0){
    // Products array
    $products_arr = array();
    $products_arr['Products'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $products_item = array(
            'productId' => $productId,
            'productName' => $productName,
            'productImage' => $productImage,
            'productDescription' => $productDescription,
            'productPrice' => $productPrice,
            'productCode' => $productCode,
            'productQuantity' => $productQuantity,
            'createdDate' =>$createdDate
        );

        // push to data

        array_push($products_arr['Products'], $products_item);
    }

    // turn to json & output

    echo json_encode($products_arr);
}else{
    // no user
    echo json_encode(
        array('message' => 'No products found')
    );

}
