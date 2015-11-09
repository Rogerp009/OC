<?php 
// --------------------------------------------------------------
// IF PROFILES ARE ENABLED IN CONFIG FILE
// --------------------------------------------------------------
if(ENABLE_USER_PROFILES == 1){ 
?>
<?php require_once(ROOT_PATH.'user/modules/accordion/banner.html.php'); ?>
<meta charset="utf-8">
<div id="accordionWrap" class="accordionWrap">
  <div id="accordion">
    <?php 
  	// --------------------------------------------------------------
  	// IF PREMIUM MEMBERSHIP IS ENABLED IN CONFIG FILE
  	// --------------------------------------------------------------
  	if(ENABLE_PREMIUM_MEMBERSHIP == 1){ ?>
    <h3><span class="ac_premiumIcon"></span><a href="#">Premium Membership</a></h3>
    <div>
      <?php require_once(ROOT_PATH.'user/modules/accordion/membership.html.php'); ?>
    </div>
    <?php }?>
    <?php 
    // --------------------------------------------------------------
  	// IF DOWNLOADS ARE ENABLED IN CONFIG FILE
  	// --------------------------------------------------------------
    if(ENABLE_DOWNLOADS == 1){ ?>
    <h3><span class="ac_downloadIcon"></span><a href="#">Descargas</a></h3>
    <div>
      <?php require_once(ROOT_PATH.'user/modules/accordion/downloads.html.php'); ?>
    </div>
  
    <h3><span class="ac_profileIcon"></span><a href="#">Perfil</a></h3>
    <div>
      <?php require_once(ROOT_PATH.'user/modules/accordion/profiles.html.php'); ?>
    </div>
    <h3><span class="ac_avatarIcon"></span><a href="#">Avatar</a></h3>
    <div>
      <?php require_once(ROOT_PATH.'user/modules/accordion/avatar.html.php'); ?>
    </div>
  </div>
</div>
<?php 
}
else
{
	// if profiles are not enabled in web.config
	require_once(ROOT_PATH.'user/modules/accordion/error_messages.php');
	echo $profiles_not_enabled;
} 
?>