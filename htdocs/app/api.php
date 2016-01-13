<?php
    include_once('../functions.php');
    header('Content-Type: application/json');

    $method = $_GET['method'];

    if(function_exists($method)){
        $method();
    } else {
        echo json_encode(array("status" => "error", "message" => "The method does not exist"));
    }

    function my_exit($status, $message, $data)
    {

        $payload = array(
            "status" => $status,
            "message" => $message
        );

        if(!empty($data)) $payload['data'] = $data;

        echo json_encode($payload);
        die();
    }


    function new_event(){

        create_event($_POST['name'], $_POST['location']);
        my_exit("success", "Event created");

    }

    function events(){
        my_exit("success", "", get_events());
    }

    function get_activity(){

        $expenses = get_expenses_activity();
        my_exit("success", "", $expenses);

    }

    function pot(){

        my_exit("success", "", get_pot($_GET['pot_id']));

    }

    function delete_pots(){
        global $database;

        $num = $database->run("DELETE FROM pots");
        my_exit("success", $num);
    }

    function get_pot_expenses(){
        $id = $_GET['pot_id'];
    }

    function new_pot(){

        if(!empty($_POST['new_event_name']) && !empty($_POST['new_event_loc'])){

            // CREATE EVENT

            create_event($_POST['new_event_name'], $_POST['new_event_loc']);

            $pid = latest_event_id();



        } else {
            $pid = $_POST['event_id'];
        }

        if(create_pot($_POST['title'], $_POST['currency'], $pid)){

            $pot = get_last_pot();
            my_exit("success", "Pot created", $pot);

        } else {
            my_exit("error", "Could not create pot");
        }

    }

    function get_my_pots(){

        $pots = get_user_pots();
        my_exit("success", "", $pots);

    }

    function new_expense(){

        create_expense($_POST['pot_id'], $_POST['amount'], $_POST['description']);
        my_exit("success", "expense created");

    }




 ?>
