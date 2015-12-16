<?php
    include_once('header.php');

    $user = get_user();
    $pots = get_user_pots();
?>

<body>

    <?php if($_GET['success'] == 1){ ?>
    <div class="uk-alert uk-alert-success">
        <p>
            Login successful ! | <a href="/logout">Logout</a>
        </p>
    </div>
    <?php } ?>
    <p>
        Hello there <?php echo $user['display_name']; ?> !
    </p>
    <h2>Your pots:</h2>
    <ul>
        <?php
        foreach($pots as $pot){
            ?>
        <li><?php echo $pot['title']." | ".$pot['ID']; ?></li>

        <?php
        }
         ?>
    </ul>
</body>
