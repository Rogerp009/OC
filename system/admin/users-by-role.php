<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title><?php if(isset($_POST['ddlUserRoles'])){echo 'Role: '.$_POST['ddlUserRoles'];}elseif(isset($_SESSION['select_q'])){echo 'Role: '.$_SESSION['select_q'];}else{echo 'Usuarios por ROL';} ?></title>
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
<?php require_once(ROOT_PATH.'admin/modules/by_role/banner.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/shared/az_nav.control.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/by_role/by_role.html.php'); ?>

</body>
</html>