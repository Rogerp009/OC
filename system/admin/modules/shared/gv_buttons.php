<div class="buttonsWrap"> 
  <!-- buttons -->
  <input name="btnDeleteSelected" type="submit" value="Delete" class="gvbtn" title="Delete Selected Users" onclick="<?php echo $delete_selected_js; ?>" />
  <input name="btnDeleteAll" type="submit" value="Delete All" class="gvbtn" title="Delete All Users" onclick="<?php echo $delete_all_users_js; ?>" />
  <input name="btnApproveSelected" type="submit" value="Approve" class="gvbtn" title="Approve Selected Users" onclick="<?php echo $approve_selected_js; ?>" />
  <input name="btnApproveAll" type="submit" value="Approve All" class="gvbtn" title="Approve All Users" onclick="<?php echo $approve_all_js; ?>" />
  <?php if(basename($_SERVER['REQUEST_URI'], ".php") == 'unapproved-users'){?>
  <input name="btnSendActivationEmail" type="submit" value="Send Confirmation" class="gvbtn" title="Send Account Activation E-mail to SELECTED Unapproved USERS so they can CONFIRM their E-mail address and ACTIVATE their account? This button is used if all account registrations must be approved by the administrator. This can be set in the configuration file. " onclick="<?php echo $send_activation_js; ?>" />
  <?php }?>
  <input name="btnUnApprove" type="submit" value="Unapprove" class="gvbtn" title="Unapprove Selected Users" onclick="<?php echo $unapprove_selected_js; ?>" />
  <input name="btnUnApproveAll" type="submit" value="Unapprove All" class="gvbtn" title="Unapprove All Users" onclick="<?php echo $unapprove_all_js; ?>" />
  <input name="btnUnlock" type="submit" value="Unlock" class="gvbtn" title="Unlock Selected Users" onclick="<?php echo $unlock_js; ?>" />
  <input name="btnUnlockAll" type="submit" value="Unlock All" class="gvbtn" title="Unlock All Users" onclick="<?php echo $unlock_all_js; ?>"/>
  <input name="btnRemoveAll" type="submit" value="Remove" class="gvbtn" title="Remove All Users From All Roles" onclick="<?php echo $remove_all_from_all_js; ?>" />
  <!-- dropdown menus --> 
  <span class="gvSelect">
  <select name="ddlAddSelected" title="Add Selected Users To Selected Role" onchange="<?php echo $add_selected_js; ?>">
    <option selected="selected">Add To</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span> 
  <span class="gvSelect">
  <select name="ddlAddAll" title="Add All Users To Selected Role" onchange="<?php echo $add_all_js; ?>">
    <option selected="selected">Add All To</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span>
  <span class="gvSelect">
  <select name="ddlRemove" title="Remove Selected Users From Selected Role" onchange="<?php echo $remove_js; ?>">
    <option selected="selected">Remove From</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span>
  <span class="gvSelect">
  <select name="ddlRemoveAll" title="Remove All Users From Selected Role" onchange="<?php echo $remove_all_js; ?>">
    <option selected="selected">Remove All From</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span>
  <span class="gvSelect">
  <select name="ddlDeleteAll" title="Delete All User Accounts Present in the Selected Role" onchange="<?php echo $delete_all_js; ?>">
    <option selected="selected">Delete All From</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span>
  <div class="clearBoth"></div>
</div>