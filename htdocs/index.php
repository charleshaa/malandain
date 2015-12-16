<?php
    include_once('functions.php');
    $uid = $_SESSION['uid'];
    global $page;
    $page = $_GET['p'];
    

    //echo "You are on the page <b>" . $page . "</b>. You user ID is ".($uid || 'unknown').".";

    if($page != 'login' && !loggedin() ){
        header('Location: /login');
    }

    if(!empty($page)){
        include_once($page.".php");
        //include_once('footer.php');
    }



 ?>
