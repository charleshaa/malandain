<?php
    echo "Will destroy";
    session_unset();
    session_destroy();
    header('Location: /login?loggedout=1');
    echo "has destroyed";
 ?>
