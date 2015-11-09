<?php require_once(ROOT_PATH.'admin/modules/user_detail/details.php'); ?>
<div class="detailsWrap">
  <form name="frmDetails" method="post" action="" class="htmlForm">
  <fieldset>
    <legend>ROLES DE USUARIO:</legend>
    <div class="divider"></div>
    <div class="rolesWrap">
        <?php require_once(ROOT_PATH.'admin/modules/user_detail/user_in_role.php'); ?>
        <div class="clearBoth"></div>
    </div>
  	<legend>DETALLES DE USUARIO:</legend>
    <div class="divider"></div>

    <!-- error msgs -->
    <ul>
    <?php echo $passwordQ_msg; ?>
    <?php echo $passwordA_msg; ?>
    <?php echo $email_msg; ?>
    </ul>
    <p><label for="userName">Nombre de Usuario:</label><input name="userName" type="text" disabled="disabled" id="userName" value="<?php echo $user_name; ?>"></p>
    <p><label for="password">Clave:</label><input name="password" type="password" disabled="disabled" id="password" value="<?php echo $pw_display; ?>"></p>
    <p><label for="email">Correo: *</label><input type="text" name="email" id="email" value="<?php echo $email; ?>"></p>
    <p><label for="approved">Aprobado?:</label><input type="checkbox" name="approved" id="approved" class="checkbox" value="<?php echo $is_approved; ?>" <?php echo $checked1; ?> /></p>
    
    <input name="UpdateUser" type="submit" value="Save Changes" class="btn" onclick="return confirm('Do you want to SUBMIT the CHANGES?');"/>
  </fieldset>
  </form>
</div>