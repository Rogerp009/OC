<?php require_once(ROOT_PATH.'modules/login/captcha_toggle.php'); ?>
<div class="frmLogin" id="frmLogin">
  <div class="inner">
    <form method="post" action="" name="frmLogin" >
      <h2>Inicio de Sesion</h2>
      <ul>
        <?php echo $txbEmptyUn ?>
        <?php echo $txbEmptyPw ?>
        <?php echo $txbInvalidCaptcha ?>
        <?php echo $accountNotFound ?>
      </ul>
      <label for="txbUn">Nombre de Usuario: *</label>
      <input id="txbUn" name="txbUn" type="text" maxlength="20" value="<?php echo $username ?>" class="txbUn" />
      <label for="txbPw">Clave: *</label>
      <input id="txbPw" name="txbPw" type="password" maxlength="50" class="txbPw"/>
      <?php
    	if(LOGIN_CAPTCHA_ON == 1 || LOGIN_CAPTCHA_ON == 0 && $count >= $captcha_on_x)
    	{
    		require_once(ROOT_PATH.'lib/recaptchalib.php');
    		$publickey = RECAPTCHA_PUBLIC_KEY;
    		echo recaptcha_get_html($publickey);
    	}
      ?>
      <br/>
      <input id="btnSubmit" name="btnSubmit" type="submit" value="Iniciar" />
    </form>
  </div>
</div>
<div class="bottomShadow"></div>