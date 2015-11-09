<?php 
require_once('web.config.php'); 
require_once(ROOT_PATH.'global.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Registro de Cuenta</title>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_STYLE; ?>"/>
<script type="text/javascript" src="js/recaptcha/theme.js"></script>
<?php require_once('js/jquery/jquery.php'); ?>
<?php if(ALLOW_PW_STRENGTH_CHECK == 1){ ?>
	<script type="text/javascript" src="js/jquery/pwstrength.js"></script>
<?php } ?>
<?php require_once(ROOT_PATH.'themes/shared.js.php'); ?>
</head>
<body>
<?php require_once(ROOT_PATH.'themes/header.control.php'); ?>
<div id="control_box">
	<?php if(SHOW_REGISTRATION == 1){
	require_once(ROOT_PATH.'modules/register/register.control.php'); 
	}else{
	require_once(ROOT_PATH.'modules/register/error_messages.php');
	echo $registration_not_enabled;
	}?>
</div>
</body>
</html>