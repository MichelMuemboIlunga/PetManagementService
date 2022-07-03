<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Users.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate users object
    $user = new Users($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $user->username = $data->username;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->userTypeId = $data->userTypeId;
    $user->createdDate = $data->createdDate;


    // Create user
    if($user->create())
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

