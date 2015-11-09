<?php require_once(ROOT_PATH.'admin/modules/add_user/add_user.php'); ?>
<?php require_once(ROOT_PATH.'admin/modules/add_user/banner.php'); ?>
<div class="addUserWrap" id="addUser">
  <form method="post" action="" name="add_User" >
    <div class="RegisterIcon"></div>

    <label for="txbUn">NOMBRE DE USUARIO: *</label>
    <input name="txbUn" type="text" id="txb2" maxlength="20" value="<?php echo $username ?>" />
    <input id="btnCheck" name="btnCheckUn" type="submit" value="Revisa" />
    <label for="txbPw">CLAVE: *</label> 
    <input name="txbPw" type="password" id="txb" maxlength="50" class="password" />
    <label for="txbConfirmPw">CONFIRMAR CLAVE: *</label>
    <input name="txbConfirmPw" type="password" id="txb" maxlength="50" />
    <label for="txbEmail">CORREO: *</label>
    <input name="txbEmail" type="text" id="txb" maxlength="50" value="<?php echo $email ?>"/>
    <label for="txbQuestion">PREGUNTA SECRETA: *</label>
    <input name="txbQuestion" type="text" id="txb" maxlength="50" value="<?php echo $question ?>"/>
    <label for="txbAnswer">RESPUESTA SECRETA: *</label>
    <input name="txbAnswer" type="text" id="txb" maxlength="50" value="<?php echo $answer ?>"/>
    <div class="divider"></div>

    <label title="¿Activar cuenta de usuario, para uso inmediato?" class="fontWeightNormal"><input type="checkbox" name="activateAccount" />Activar cuenta?</label>
    <div class="clearBoth"></div>
    <input id="btnSubmit" name="btnSubmit" type="submit" value="Crear Cuenta" onclick="return confirm('Listo?');" />
  </form>
</div>