<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','Maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Usuario pago</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_STYLE; ?>"/>

<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
</head>
<body>
<?php require_once(ROOT_PATH.'admin/themes/header.control.php'); ?>
<?php require_once(ROOT_PATH.'admin/themes/top_menu.control.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/cpanel/premium.html.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/cpanel/paypal_dev.html.php'); ?>

</body>
</html>