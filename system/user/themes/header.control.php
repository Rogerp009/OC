<?php 
require_once(ROOT_PATH.'user/modules/accordion/get_user_name.php');
?>
<div class="headerWrap">
  <div class="loginNameStatus">
    <form id='frmLogout' name='frmLogout' method='post' action='' class='frmLogout'>
      <?php require_once(ROOT_PATH.'user/themes/logout.php'); ?>
      <a href="#"><span class="greetings"></span><?php echo (!empty($_SESSION['UserName'])?'Bienvenido! '.$_SESSION['UserName']:'Bienvenido de vuelta! '.$_COOKIE['user']) ?></a>
    </form>
  </div>
  <div class="headerDateTime"><?php echo strtoupper(date("l, F jS\, Y")); ?></div>
  <div class="headerTitleText"> Mi cuenta</div>
</div>
<?php if(SCHEDULED_MAINTENANCE == 1){header('Location:'.UNDER_CONSTRUCTION_PAGE);} ?>