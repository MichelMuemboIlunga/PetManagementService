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
$users = new Users($db);

// user query
$result = $users->getAll();

// get row count
$num = $result->rowCount();
// check if any user
if($num > 0){
    // user array
    $users_arr = array();
    $users_arr['users'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $users_item = array(
            'userid' => $userId,
            'username' => $username,
            'email' => $email,
            'role' => $user_role,
            'isActive' => $isActive
        );

        // push to data

        array_push($users_arr['users'], $users_item);
    }

    // turn to json & output

    echo json_encode($users_arr);
}else{
    // no user
    echo json_encode(
        array('message' => 'No user found')
    );

}
