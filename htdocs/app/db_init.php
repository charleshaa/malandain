<?php
    include_once('class.db.php');

    global $database;

    $database = new EasyPDO("mysql:host=127.0.0.1;port=8889;dbname=malandain;charset=UTF8", "root", "root");

    $userQuery = "CREATE TABLE IF NOT EXISTS users ("
        ."ID INT NOT NULL AUTO_INCREMENT,"
        ."username varchar(255) NOT NULL,"
        ."password_hash TEXT NOT NULL,"
        ."display_name VARCHAR(255) NOT NULL,"
        ."email TEXT NOT NULL,"
        ."PRIMARY KEY (ID)"
    .");";

    $eventsQuery = "CREATE TABLE IF NOT EXISTS events ("
        ."ID INT NOT NULL AUTO_INCREMENT,"
        ."title varchar(255) NOT NULL,"
        ."slug varchar(255) NOT NULL,"
        ."location TEXT,"
        ."PRIMARY KEY (ID)"
    .");";

    $potsQuery = "CREATE TABLE IF NOT EXISTS pots ("
        ."ID INT NOT NULL AUTO_INCREMENT,"
        ."title varchar(255) NOT NULL,"
        ."slug varchar(255) NOT NULL,"
        ."amount DOUBLE NOT NULL DEFAULT 0.0,"
        ."num_people INT NOT NULL DEFAULT 0,"
        ."status enum('open', 'closed', 'paid') NOT NULL DEFAULT 'open',"
        ."currency enum('euro', 'chf', 'dollar') NOT NULL DEFAULT 'chf',"
        ."event_id INT,"
        ."PRIMARY KEY (ID)"
    .");";

    $spendingsQuery = "CREATE TABLE IF NOT EXISTS spendings ("
        ."ID INT NOT NULL AUTO_INCREMENT,"
        ."amount DOUBLE NOT NULL DEFAULT 0.0,"
        ."description TEXT NOT NULL DEFAULT '',"
        ."date DATETIME,"
        ."author INT,"
        ."pot_id INT,"
        ."PRIMARY KEY (ID)"
    .");";

    $potMembersQuery = "CREATE TABLE IF NOT EXISTS pot_members ("
        ."pot_id INT,"
        ."user_id INT,"
        ."weight DOUBLE NOT NULL DEFAULT 1.0,"
        ."PRIMARY KEY (pot_id)"
    .");";

    $spendingsPeopleQuery = "CREATE TABLE IF NOT EXISTS spendings_people ("
        ."spending_id INT,"
        ."user_id INT,"
        ."PRIMARY KEY (spending_id)"
    .");";

    $database->run($userQuery);
    $database->run($eventsQuery);
    $database->run($potsQuery);
    $database->run($spendingsQuery);
    $database->run($potMembersQuery);
    $database->run($spendingsPeopleQuery);

 ?>
