<?php

setcookie('user', null, time() - 3600);
setcookie('pass', null, time() - 3600);
header('Location:'.SITE_URL.'login.php');
?>