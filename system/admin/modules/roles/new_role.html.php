<?php require_once(ROOT_PATH.'admin/modules/roles/role.action.php'); ?>
<!-- msg -->
<?php echo $msg; ?>
<div class="detailsWrap">
<form name="frmNewRole" method="post" action="" class="htmlForm">
<fieldset>
  	<legend>ADD NEW ROLE:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
    <p>INFO: Here you can create a new user role.</p>
    </div>
    <p><label for="role">New Role Name: *</label><input name="role" type="text" maxlength="50" class="txb"></p>
    <p><label for="description">Description:</label><textarea name="description" rows="5" id="comment"></textarea></p>
    <input name="NewRole" type="submit" value="Create New Role" class="gvbtn btn" onclick="return confirm('CREATE New ROLE?');">
</fieldset>
</form>
<div class="clearBoth"></div>
</div>