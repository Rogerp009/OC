<?php require_once(ROOT_PATH.'user/modules/accordion/profiles.php'); ?>
<div class="profileWrap">
  <form name="frmProfile" method="post" action="" class="htmlForm">
	<ul>
    <?php echo $msg; ?>
    </ul>
    <p><label for="FirstName">Primer Nombre:</label><input name="FirstName" type="text" id="FirstName" maxlength="20" value="<?php echo $f_first_name ?>" ></p>
    <p><label for="LastName">Primer Apellido:</label><input name="LastName" type="text" id="LastName" maxlength="20" value="<?php echo $f_last_name ?>" ></p>
    <p><label for="ProfileTitle">Nombre de Perfil:</label><input name="ProfileTitle" type="text" id="ProfileTitle" maxlength="200"value="<?php echo $f_profile_title ?>"  ></p>
    <p><label for="Phone">Telefono de contacto:</label><input name="Phone" type="text" id="Phone" maxlength="20" value="<?php echo $f_phone ?>" ></p>
    <p><label for="Country">Pais:</label>
    <select name="Country">
    <option value="<?php echo $f_country ?>" selected="selected"><?php echo $f_country ?></option>
    <option value="none">Do not display my country</option>
    <option value="">----------</option>

    <option value="Venezuela">Venezuela</option>

    
    </select>
    </p>
    <input name="btnUpdatePf" type="submit" value="Save Changes" class="gvbtn btn" onclick="return confirm('SAVE Changes to Your PROFILE?');"/>
  </form>
</div>