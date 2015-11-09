<?php require(ROOT_PATH.'admin/modules/menu/modal_details.php'); ?>
<div class="detailsWrap marginTop10">
  <form name="frmDetails" method="post" action="" class="htmlForm">
  <fieldset>
  	<legend>MENU ITEM DETAILS:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
    <p>INFO: Here you can View and Edit the details of the Current Menu Item.</p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg; ?>
    </ul>
    <p>
    <label for="ddlMenuName">Menu Name (Group):</label><select name="ddlMenuName" title="Select Menu Name (Group) for current menu item.">
      <option value="<?php echo $menu_name; ?>" selected="selected"><?php echo $menu_name; ?></option>
      <?php require(ROOT_PATH.'admin/modules/menu/get_menu_names.php'); ?>
    </select>
    </p>
    <p><label for="MenuLabel">Label:</label><input name="MenuLabel" type="text" id="MenuLabel" maxlength="50" value="<?php echo $menu_label; ?>" title="This is what will be displayed on the menu."></p>
    <p><label for="MenuUrl">Url:</label><input type="text" name="MenuUrl" id="MenuUrl" maxlength="100" value="<?php echo $menu_url; ?>" title="The URL this menu item links to. You can point to an internal, external or # file."></p>
    <p>
    <label for="ddlMenuTarget">URL Target:</label><select name="MenuTarget" title="Select a Target attribute for this URL.">
      <option value=""></option>
      <option value="<?php echo $menu_target; ?>" selected="selected"><?php echo $menu_target; ?></option>
      <option value="_blank">_blank</option>
      <option value="_new">_new</option>
      <option value="_parent">_parent</option>
      <option value="_self">_self</option>
      <option value="_top">_top</option>
    </select>
    </p>
    <p><label for="MenuTitle">URL Title:</label><input type="text" name="MenuTitle" id="MenuTitle" maxlength="100" value="<?php echo $menu_title; ?>" title="The URL title that shows when the mouse is hovered over the menu item."></p>
    <p>
    <label for="ddlParentLabel">Parent Menu:</label><select name="ddlParentLabel" title="To make this menu item a Top Level Item, select _TopLevel. To make it a Sub-Menu, select a menu item under which you want it to appear.">
      <option value="<?php echo $parent_id.'|'.$parent_label; ?>" selected="selected"><?php echo $parent_label; ?></option>
      <option value="0|_TopLevel">_TopLevel</option>
      <?php require(ROOT_PATH.'admin/modules/menu/get_menu_labels.php'); ?>
    </select>
    </p>
    <p><label for="OrdinalPosition">Ordinal Position:</label><input type="text" name="OrdinalPosition" id="OrdinalPosition" maxlength="11" value="<?php echo $ordinal_position; ?>" title="Must be a number (int) value. Ordinal Position is the position of the menu item either from left to right (if top level) or top to bottom (under the parent)."></p>
    <p><label for="MenuDescription">Comment:</label><input type="text" name="MenuDescription" id="MenuDescription" maxlength="250" value="<?php echo $menu_description; ?>" title="Here you can add a note/description for this menu item. This is for you own references and will not show on the menu." /></p>
    <p><label for="IsEnabled">Enable?:</label><input type="checkbox" name="IsEnabled" id="IsEnabled" class="checkbox" value="<?php echo $is_enabled; ?>" <?php echo $checked1; ?> title="Check to enable and show or uncheck to disable and hide on the menu." /></p>
    <input name="btnUpdateMenuItem" type="submit" value="Save Changes" class="btn" onclick="return confirm('Do you want to SUBMIT the CHANGES?');"/>
  </fieldset>
  </form>
</div>