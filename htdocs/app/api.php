<?php
    include_once('db_init.php');
    header('Content-Type: application/json');

    $method = $_GET['method'];

    if(function_exists($method)){
        $method();
    } else {
        echo json_encode(array("status" => "error", "message" => "The method does not exist"));
    }

    function my_exit($status, $message)
    {
        echo json_encode(array("status" => $status, "message" => $message));
        die();
    }

    function create_user()
    {
        // TODO: Create a user in the database
        global $database;
        if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
            my_exit('error', 'Required fields are empty');
        }

        $password = md5($_POST['password']);

        $user = array(
            'username' => $_POST['username'],
            'password_hash' => $password,
            'email' => $_POST['email'],
            'display_name' => $_POST['username']
        );

        $row = $database->insert('users', $user);
        if($row){
            my_exit('success', 'User has been created');
        } else {
            my_exit('error', 'Error');
        }
    }

    function create_event($value='')
    {
        // TODO: Create an event
    }



 ?>
