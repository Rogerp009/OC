<?php 
require_once('web.config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>ADMINCP OC /Inicio de Sesion</title>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_STYLE; ?>"/>
<?php require_once(ROOT_PATH.'themes/shared.js.php'); ?>
</head>
<body>
<?php require_once(ROOT_PATH.'themes/header.control.php'); ?>
<div id="control_box">
	<?php require_once(ROOT_PATH.'modules/login/login.control.php'); ?>
</div>
</body>
</html>