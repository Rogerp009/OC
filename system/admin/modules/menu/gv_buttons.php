<div class="buttonsWrap"> 
  <!-- buttons -->
  <input name="btnDeleteSelected" type="submit" value="Delete" class="gvbtn" title="Delete Selected Menu Items" onclick="<?php echo $delete_selected_js; ?>" />
  <input name="btnDeleteAll" type="submit" value="Delete All" class="gvbtn" title="Delete All Menu Items" onclick="<?php echo $delete_all_js; ?>" />
  <input name="btnEnableSelected" type="submit" value="Enable" class="gvbtn" title="Enable Selected Menu Items" onclick="<?php echo $enable_selected_js; ?>" />
  <input name="btnEnableAll" type="submit" value="Enable All" class="gvbtn" title="Enable All Menu Items" onclick="<?php echo $enable_all_js; ?>" />
  <input name="btnDisableSelected" type="submit" value="Disable" class="gvbtn" title="Disable Selected Menu Items" onclick="<?php echo $disable_selected_js; ?>" />
  <input name="btnDisableAll" type="submit" value="Disable All" class="gvbtn" title="Disable All Menu Items" onclick="<?php echo $disable_all_js; ?>" />
  <span class="gvSelect">
  <select name="ddlAddToParent" title="Move Selected Menu Items To Selected Parent" onchange="<?php echo $move_to_parent_js; ?>">
    <option selected="selected">Move To Parent</option>
    <?php require(ROOT_PATH.'admin/modules/menu/get_menu_labels.php'); ?>
  </select>
  </span> 
  <span class="gvSelect">
  <select name="ddlAddSelected" title="Move Selected Menu Items To Selected Menu Group" onchange="<?php echo $move_selected_js; ?>">
    <option selected="selected">Move To Group</option>
    <?php require(ROOT_PATH.'admin/modules/menu/get_menu_names.php'); ?>
  </select>
  </span> 
  <span class="gvSelect">
  <select name="ddlDeleteGroup" title="Delete Selected Menu Group and All associated Menu Items" onchange="<?php echo $delete_selected_group_js; ?>">
    <option selected="selected">Delete Menu Group</option>
    <?php require(ROOT_PATH.'admin/modules/menu/get_menu_names.php'); ?>
  </select>
  </span> 
  <span class="gv_abtn" title="Menus are retrieved based on their Menu Group Name. You can create unlimited menu groups and add unlimited menu items to them."><a href="menu-add-new.php" class="modal">Add + Edit Menu Groups</a></span>
  <span class="gv_abtn" title="Add a new Menu Item to an existing Menu Group."><a href="menu-add-new-item.php" class="modal">Add Menu Item</a></span>
  <div class="clearBoth"></div>
</div>