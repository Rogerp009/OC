<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','Maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Detalles de Usuario</title>

<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_STYLE; ?>"/>

<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
<?php require_once(ROOT_PATH.'js/jquery/datepicker.php'); ?>
</head>
<body class="md_padding">
<?php require_once(ROOT_PATH.'admin/modules/user_detail/tabs.html.php'); ?>
</body>
</html>