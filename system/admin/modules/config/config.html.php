<?php require_once(ROOT_PATH.'admin/modules/config/config.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/config/banner.php'); ?>

<form action="" method="post" name="editConfig" class="htmlForm">
  <div class="editConfigWrap">
    <textarea name="txbConfig" spellcheck="false"><?php echo $contents ?></textarea>
  </div>
  <input name="submit" type="submit" value="Save Changes" class="gvbtn marginLeft20" onclick="<?php echo $save_changes_js; ?>">
</form>
