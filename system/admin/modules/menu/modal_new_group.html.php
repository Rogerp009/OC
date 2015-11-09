<?php require(ROOT_PATH.'admin/modules/menu/modal_new_group.php'); ?>
<div class="detailsWrap marginTop10">
  <form name="frmMenuGroup" method="post" action="" class="htmlForm">
  <fieldset>
  	<legend>CREATE A NEW MENU GROUP:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
    <p>INFO: Here you can Create a New Menu Group. Menu Groups allow you to create multiple menu sets that can be displayed individually on different pages.</p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg; ?>
    </ul>
    <p><label for="GroupName">Menu Group Name:</label><input name="GroupName" type="text" id="GroupName" maxlength="100" title="Here you can name this group. Make it short and sweet."></p>
    <p><label for="GroupDescription">Comment:</label><input type="text" name="GroupDescription" id="GroupDescription" maxlength="255" title="Here you can add a note/description for this menu group. This is for you own references and will not show on the menu." /></p>
    <input name="btnAddMenuGroup" type="submit" value="Save Changes" class="btn" onclick="return confirm('Do you want to SAVE the CHANGES?');"/>
  </fieldset>
  <fieldset>
  	<legend>EDIT MENU GROUP:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
    <p>INFO: Here you can Select a Menu Group and Edit it's Details.</p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg_2; ?>
    </ul>
    <p>
    <label for="ddlMenuName">Select a Menu Group:</label>
    <select name="ddlMenuName" title="Select Menu Group to Edit." onchange="form.submit();">
      <option value="<?php echo $menu_name; ?>" selected="selected"><?php echo $menu_name; ?></option>
      <?php require(ROOT_PATH.'admin/modules/menu/get_menu_names.php'); ?>
    </select>
    </p>
    <p><label for="EditGroupName">Menu Group Name:</label><input name="EditGroupName" type="text" id="EditGroupName" maxlength="100" value="<?php echo $f_group_name; ?>" title="Here you can name this group. Make it short and sweet."></p>
    <p><label for="EditGroupDescription">Comment:</label><input type="text" name="EditGroupDescription" id="GroupDescription" maxlength="255" value="<?php echo $f_group_description; ?>" title="Here you can add a note/description for this menu group. This is for you own references and will not show on the menu." /></p>
    <input name="btnEditMenuGroup" type="submit" value="Save Changes" class="btn" onclick="return confirm('Do you want to SAVE the CHANGES?');"/>
  </fieldset>
  </form>
</div>