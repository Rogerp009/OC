<div class="gvBanner">
  <?php require_once(ROOT_PATH.'admin/modules/shared/toggle_buttons.php'); ?>
  <span class="title"> Dynamic Menus ...
  <?php if(isset($_GET['az']) && !empty($_GET['az']) && strlen($_GET['az']) <= 2 && !is_numeric($_GET['az'])){echo '('.$_GET['az'].')';}else{echo '(%)';}?>
  </span> <span class="smallFont bullet">Parent ID 0 (zero) = Top Level Menu. </span> <span class="smallFont bullet">None 0 (zero) Parent ID = Menu ID. </span> <span class="smallFont bullet">Position = Left to Right / Top to Bottom.</span> </div>
