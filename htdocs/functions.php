<?php
    ini_set('error_reporting', E_ERROR);
    ini_set('display_errors', true);
    include_once('app/db_init.php');
    session_start();
    ob_start();

    function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

      // trim
      $text = trim($text, '-');

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // lowercase
      $text = strtolower($text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      if (empty($text))
      {
        return 'n-a';
      }

      return $text;
    }

    function create_user($username, $password, $email)
    {
        // TODO: Create a user in the database
        global $database;

        $password = md5($password);

        $user = array(
            'username' => $username,
            'password_hash' => $password,
            'email' => $email,
            'display_name' => $username
        );

        $row = $database->insert('users', $user);
        if($row){
            return $row;
        } else {
            return false;
        }
    }

    function login_user($username, $password){

        global $database;

        $pass = md5($password);

        $user = $database->select('users', '*', "username = '".$username."'")[0];

        if(empty($user)) return 0;
        if($user['password_hash'] != $pass) return -1;


        $_SESSION['uid'] = $user['ID'];
        $_SESSION['user'] = $user;
        $_SESSION['logged_in'] = true;
        return $user;

    }

    function get_user($uid){
        global $database;
        if(empty($uid)) return $_SESSION['user'];

        return $database->select('users', '*', "ID = ".$uid);
    }

    function loggedin(){
        return $_SESSION['logged_in'] ? true : false;
    }

    /**
     * Creates a pot
     * @param  array $args array(title, currency, event_id)
     * @return bool        success
     */
    function create_pot($title, $currency = 'chf', $event_id = 0){
        global $database;

        $pl = array(
            'title' => $title,
            'currency' => $currency,
            'event_id' => $event_id,
            'amount' => 0.0,
            'num_people' => 1,
            'status' => 'open',
            'slug' => slugify($title)
        );

        $one = $database->insert('pots', $pl);
        $id = $database->fetchOne("SELECT ID FROM pots ORDER BY ID DESC LIMIT 1");
        $two = $database->insert('pot_members', array('pot_id' => $id, 'user_id' => $_SESSION['uid'], 'weight' => 1));

        return $one + $two == 2;


    }

    function get_user_pots(){
        global $database;

        $uid = $_SESSION['uid'];

        $sql = "SELECT * FROM pots p, pot_members pp WHERE pp.user_id = {$uid} AND pp.pot_id = p.ID";
        $events = $database->fetchAll($sql);
        return $events;
    }


 ?>
