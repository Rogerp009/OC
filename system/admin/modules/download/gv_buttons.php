<?php require_once(ROOT_PATH.'admin/modules/download/gv_actions.php');?>
<div class="buttonsWrap"> 
  <!-- buttons -->
  <input name="btnDeleteSelected" type="submit" value="Delete" class="gvbtn" title="Delete Selected Downloads" onclick="<?php echo $delete_selected_js; ?>" />
  <input name="btnDeleteAll" type="submit" value="Delete All" class="gvbtn" title="Delete All Downloads" onclick="<?php echo $delete_all_js; ?>" />
  <input name="btnEnableSelected" type="submit" value="Enable" class="gvbtn" title="Enable Selected Downloads" onclick="<?php echo $enable_selected_js; ?>" />
  <input name="btnEnableAll" type="submit" value="Enable All" class="gvbtn" title="Enable All Downloads" onclick="<?php echo $enable_all_js; ?>" />
  <input name="btnDisableSelected" type="submit" value="Disable" class="gvbtn" title="Disable Selected Downloads" onclick="<?php echo $disable_selected_js; ?>" />
  <input name="btnDisableAll" type="submit" value="Disable All" class="gvbtn" title="Disable All Downloads" onclick="<?php echo $disable_all_js; ?>" />
  <span class="gv_abtn" title="Upload a new file and make it avalable to premium and none premium users."><a href="downloads-add-new.php" class="modal">Add+ New Download</a></span>
<div class="clearBoth"></div>
</div>