<?php 
require_once(ROOT_PATH.'themes/ie-detect.php');
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'user/modules/accordion/get_user_name.php');
?>
<div class="header"> 
  <form id='frmLogout' name='frmLogout' method='post' action='' class='frmLogout'>
    <?php require_once(ROOT_PATH.'themes/logout.php'); ?>
    <?php if(!isset($user_name)){ ?>
      <span class="link"><a href="login.php" title="Iniciar Sesion" class="btnLogin">Inicio</a></span> 
    <?php } ?>
    <span class="link"><a href="index.php" title="Home page ...">Inicio</a></span>
    <span class="link"><a href="user/index.php" title="Administra tu cuenta..."><?php if(!empty($_SESSION['UserName'])){echo 'Bienvenido! '.$_SESSION['UserName'];}elseif(!empty($_COOKIE['user'])){echo 'Bienvenido de Regreso! '.$_COOKIE['user'];}else{echo 'Mi cuenta';} ?></a></span> 
  </form>
</div>

