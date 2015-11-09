<?php require_once(ROOT_PATH.'admin/modules/user_detail/profile.php'); ?>
<div class="detailsWrap">
<form name="frmProfile" method="post" action="" class="htmlForm">
<fieldset>
  	<legend>PERFIL DE USUARIO:</legend>
    <div class="divider"></div>

    <p><label for="FirstName">PRIMER NOMBRE:</label><input name="FirstName" type="text" id="FirstName" maxlength="20" value="<?php echo $f_first_name ?>" ></p>
    <p><label for="LastName">PRIMER APELLIDO:</label><input name="LastName" type="text" id="LastName" maxlength="20" value="<?php echo $f_last_name ?>" ></p>
    <div class="clearLeft"></div>
    <p><label for="Country">Pais:</label>
    <select name="Country">
    <option value="<?php echo $f_country ?>" selected="selected"><?php echo $f_country ?></option>
    <option value="none">No mostrar</option>
    <option value="">----------</option>
    
    <option value="Venezuela">Venezuela</option>
 
    </select>
    </p>
    
    <input name="btnSaveProfile" type="submit" value="Grabar" class="gvbtn btn" onclick="return confirm('Seguro?');">
    <input name="btnDeleteProfile" type="submit" value="Borrar Perfil" class="gvbtn btn" onclick="return confirm('Seguro?');">
</fieldset>
</form>
<form name="frmAvatar" method="post" action="" enctype="multipart/form-data" class="htmlForm">
    <fieldset>
    <legend>SUBIR AVATAR:</legend>
    <div class="divider"></div>
    <div class="infoBanner2">
      <p>REQUERIMIENTOS: <?php echo AVATAR_FILE_SIZE / 1024 ?> kb max. Tipos: gif, jpg, png</p>
    </div>
    <!-- error msgs -->
    <ul>
    <?php echo $msg; ?>
    </ul>
    <p><input name="selectFile" type="image" src="<?php echo $f_avatar_image; ?>" class="img"></p>
    <p><label for="fileUpload">Avatar:</label><input name="fileUpload" type="file" id="fileUpload" maxlength="255" ></p>
    <input name="btnUploadAvatar" type="submit" value="Subir" class="gvbtn btn" onclick="return confirm('Seguro?');"/>
    </fieldset>
</form>
<div class="clearBoth"></div>
</div>