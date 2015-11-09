<?php 
require_once('web.config.php');

?>
<!DOCTYPE html>
<html lang="EN">
<head>
<meta charset="utf-8">
<title>CP // OC</title>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_STYLE; ?>"/>
<?php require_once(ROOT_PATH.'themes/shared.js.php'); ?>
</head>
<body>
<?php require_once(ROOT_PATH.'themes/header.control.php'); ?>
<div  id="control_box" class="indexWrap">
  <div class="inner">
    <div class="indexTitle"><span>Bienvenido al panel de Cursos</span> </div>
    <ul>
      <li><a href="admin/index.php" title="">AdminCP<span class="adminIcon"></span></a></li>
      <li><a href="user/index.php" title="">UsuarioCP<span class="usersIcon"></span></a></li>
      <li><a href="register.php" title="">RegisterP<span class="registerIcon"></span></a></li>
    </ul>
    <div class="clearLeft"></div>
  </div>
</div>
</body>
</html>