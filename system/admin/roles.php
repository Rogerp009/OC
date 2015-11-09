<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','Maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Administracion de Roles</title>

<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
</head>
<body>
<div id="Header">
  <?php require_once(ROOT_PATH.'admin/themes/header.control.php'); ?>
</div>
<div id="Menu">
  <?php require_once(ROOT_PATH.'admin/themes/top_menu.control.php'); ?>
</div>
<?php require_once(ROOT_PATH.'admin/modules/roles/banner.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/shared/az_roles_nav.control.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/roles/roles.html.php'); ?>
</body>
</html>