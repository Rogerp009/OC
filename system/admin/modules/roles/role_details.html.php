<?php require_once(ROOT_PATH.'admin/modules/roles/role.action.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/roles/role_details.php'); ?>
<!-- msg -->
<?php echo $msg; ?>
<div class="detailsWrap">
<form name="frmEditRole" method="post" action="" class="htmlForm">
<fieldset>
  	<legend>EDIT ROLE:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
    <p>INFO: Here you can edit the currently selected user role.</p>
    </div>
    <p><label for="role">Role Name: *</label><input name="role" type="text" maxlength="50" class="txb" value="<?php echo $role_name; ?>"></p>
    <p><label for="description">Description:</label><textarea name="description" rows="5" id="comment"><?php echo $role_description; ?></textarea></p>
    <input name="EditRole" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE Changes to CURRENT ROLE?');">
</fieldset>
</form>
<div class="clearBoth"></div>
</div>