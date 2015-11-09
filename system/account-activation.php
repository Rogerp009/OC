<?php 
require_once('web.config.php'); 
require_once(ROOT_PATH.'global.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Activacion de Cuenta</title>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_STYLE; ?>"/>
</head>
<body>
<?php require_once(ROOT_PATH.'modules/activation/activation.control.php'); ?>
</body>
</html>