<?php

    //if($_SESSION['uid']) header('Location: /home');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // We are loging in or registering
        $type = $_POST['type'];
        if($type == "register"){

            $id = create_user($_POST['username'], $_POST['password'], $_POST['email']);

            if($id){
                header('Location: /login?success=1&username='.$_POST['username']);
            }

        } else if ($type == "login") {

            $user = login_user($_POST['username'], $_POST['password']);
            if($user === -1){
                // Wrong password
            } else if($user === 0){
                // Does not exist
            } else {
                header('Location: /home?success=1');
            }


        }



    }

include_once('header.php');
 ?>
    <body class="uk-height-1-1">

        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width: 250px;">

                <h3>Comptes entre amis</h3>
                <?php if($_GET['success'] == "1"){ ?>
                <div class="uk-panel uk-panel-success uk-panel-box">
                    <p>
                        You have successfully registered as <b><?php echo $_GET['username']; ?></b>, please use your credentials to login.
                    </p>
                </div>
                <?php } ?>
                <?php if($user == -1){ ?>
                <div class="uk-panel uk-margin-large-bottom uk-panel-box-danger uk-panel-box">
                    <p>
                        Wrong password.
                    </p>
                </div>
                <?php } ?>
                <?php if($user === 0){ ?>
                <div class="uk-panel uk-margin-large-bottom uk-panel-box-danger uk-panel-box">
                    <p>
                        No user registered under this username.
                    </p>
                </div>
                <?php } ?>
                <?php if($_GET['loggedout'] == 1){ ?>
                <div class="uk-alert uk-alert-success">
                    <p>
                        You have logged out.
                    </p>
                </div>
                <?php } ?>
                <ul class="uk-subnav uk-text-center uk-subnav-line">
                    <li class="uk-active"><a href="#login" class="subnav">Login</a></li>
                    <li class=""><a href="#register" class="subnav">Register</a></li>
                </ul>

                <form id="login" class="uk-panel uk-panel-box uk-form" action="" method="POST">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" name="username" value="<?php echo $_POST['username']; ?>" type="text" placeholder="Username">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="uk-form-row">
                        <input type="submit" class="uk-width-1-1 uk-button uk-button-primary uk-button-large" value="Login">
                    </div>

                    <input type="hidden" name="type" value="login">
                </form>
                <form id="register" class="uk-panel uk-panel-box uk-form uk-hidden" action="" method="POST">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" name="username" type="text" placeholder="Username">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" name="password" type="password" placeholder="Password">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" name="email" type="email" placeholder="Email">
                    </div>
                    <div class="uk-form-row">
                        <input type="submit" class="uk-width-1-1 uk-button uk-button-primary uk-button-large" value="Register">
                    </div>

                    <input type="hidden" name="type" value="register">
                </form>

            </div>
        </div>

    </body>

</html>
