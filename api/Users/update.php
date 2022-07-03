<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/Users.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new Users($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set UserID to update
$user->userId = $data->userId;

$user->username = $data->username;
$user->password = $data->password;
$user->email = $data->email;
$user->createdDate = $data->createdDate;


// Update user
if($user->update()) {
    echo json_encode(
        $data,
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Post Not Updated')
    );
}


