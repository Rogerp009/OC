<?php 

require_once('../web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('superadmin','Maximus');
require_once(ROOT_PATH.'modules/authorization/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Detalles de Menu</title>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_STYLE; ?>"/>
<link rel="shortcut icon" href="../images/favicon.gif"/>
<link rel="shortcut icon" href="../images/favicon.ico"/>
<?php require_once(ROOT_PATH.'admin/themes/shared.js.php'); ?>
</head>
<body class="md_padding">
<?php require_once(ROOT_PATH.'admin/modules/menu/modal_details.html.php'); ?>
</body>
</html>