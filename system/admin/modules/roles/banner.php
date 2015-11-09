<div class="gvBanner">
  <?php require_once(ROOT_PATH.'admin/modules/shared/toggle_buttons.php'); ?>
  <span class="title"> User Roles ...
  <?php if(isset($_GET['az']) && !empty($_GET['az']) && strlen($_GET['az']) <= 2 && !is_numeric($_GET['az'])){echo '('.$_GET['az'].')';}else{echo '(%)';}?>
  </span> </div>
