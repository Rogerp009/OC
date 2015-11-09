
<div class="headerWrap">
  <div class="loginNameStatus">
    <form id="frmLogout" name="frmLogout" method="post" action="" class="frmLogout">
	  <?php require_once(ROOT_PATH."admin/themes/logout.php"); ?>
      <?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0){ ?>
      <?php } ?>
    </form>
  </div>
  <div class="headerDateTime"><?php echo strtoupper(date("l, F jS\, Y")); ?></div>
  <div class="headerTitleText"> ADMINCP // OC </div>
</div>
<?php if(SCHEDULED_MAINTENANCE == 1){header('Location:'.UNDER_CONSTRUCTION_PAGE);} ?>