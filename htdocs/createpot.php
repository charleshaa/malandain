<?php

    $bool = create_pot("POT TEST");

    $pots = get_user_pots();

 ?>
<pre>
    <?php echo $bool."\r\n"; ?>
    <?php print_r($pots); ?>
</pre>
