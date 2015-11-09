<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('owner','superadmin','administrator');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Detalle de Roles</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_STYLE; ?>"/>
<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
</head>
<body class="md_padding">
<?php require_once(ROOT_PATH.'admin/modules/roles/role_details.html.php'); ?>
</body>
</html>