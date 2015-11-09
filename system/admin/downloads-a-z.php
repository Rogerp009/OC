<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','Maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Usuarios Pagos</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_STYLE; ?>"/>

<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
</head>
<body>
<div id="Header">
	<?php require_once(ROOT_PATH.'admin/themes/header.control.php'); ?>
</div>
<div id="Menu">
  <?php require_once(ROOT_PATH.'admin/themes/top_menu.control.php'); ?>
</div>
<?php require_once(ROOT_PATH.'admin/modules/download/banner.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/download/downloads_az_nav.control.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/download/downloads_az.html.php'); ?>

</body>
</html>