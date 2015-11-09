<?php require_once(ROOT_PATH.'modules/register/captcha_toggle.php'); ?>
<div class="frmRegister" id="frmRegister">
  <div class="inner">
    <form method="post" action="" name="frm_Register" >
      <h2>Cuenta Nueva</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
        <?php echo $txbEmptyPw ?>
        <?php echo $txbEmptyConfirmPw ?>
        <?php echo $passwordMismatch ?>
        <?php echo $passwordTooShort ?>
        <?php echo $passwordNumber ?>
        <?php echo $passwordChar ?>
        <?php echo $userExist ?>
        <?php echo $userInPw ?>
        <?php echo $emailNotValid ?>
        <?php echo $txbEmptyEmail ?>
        <?php echo $txbEmptyQuestion ?>
        <?php echo $txbEmptyAnswer ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $txbUserNameCheck ?>
      </ul>
      <label for="txbUn">NOMBRE DE USUARIO: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $username ?>" class="txbUn" />
      <input id="btnCheck" name="btnCheckUn" type="submit" value="check" />
      <label for="txbPw">CLAVE: *</label> 
      <label id="subtext">(minimo <?php echo MIN_PASSWORD_LENGTH ?> de caracteres <?php echo REQUIRE_NUMBER ?> 1 digito, <?php echo REQUIRE_SPECIAL_CHAR ?> un caracter unico*)</label>
      <input id="txbPw" name="txbPw" type="password" maxlength="50" class="password" />
      <label for="txbConfirmPw">CLAVE: *</label>
      <input id="txbConfirmPw" name="txbConfirmPw" type="password" maxlength="50" class="txbConfirmPw" />
      <label for="txbEmail">CORREO: *</label>
      <input id="txbEmail" name="txbEmail" type="text" maxlength="50" value="<?php echo $email ?>" class="txbEmail" />
      <label for="txbQuestion">PREGUNTA DE SEGURIDAD: *</label>
      <input id="txbQuestion" name="txbQuestion" type="text" maxlength="50" value="<?php echo $question ?>" class="txbQuestion" />
      <label for="txbAnswer">RESPUESTA DE SEGURIDAD: *</label>
      <input id="txbAnswer" name="txbAnswer" type="text" maxlength="50" value="<?php echo $answer ?>" class="txbAnswer" />
      <?php
    	if(REGISTER_CAPTCHA_ON == 1)
    	{
    		require_once(ROOT_PATH.'lib/recaptchalib.php');
    		$publickey = RECAPTCHA_PUBLIC_KEY;
    		echo recaptcha_get_html($publickey);
    	}
      ?>
      <input id="btnSubmit" name="btnSubmit" type="submit" value="Registrar" />

      </p>
    </form>
  </div>
</div>
<div class="bottomShadow"></div>