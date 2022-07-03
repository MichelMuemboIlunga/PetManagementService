<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/Users.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// Instantiate  users object
$user = new Users($db);

// Get ID
$user->userId = isset($_GET['userId']) ? $_GET['userId'] : die();

// GET user
$user->getUserById();

// create array

$users_item = array(
    'userId' => $user->userId,
    'username' => $user->username,
    'email' => $user->email,
    'role' => $user->role,
    'createdDate' => $user->createdDate,
    'isActive' => $user->isActive
);

// Make json
print_r(json_encode($users_item));



