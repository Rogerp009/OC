<?php require_once(ROOT_PATH.'admin/modules/user_detail/tabs.action.php'); ?>
<?php echo $msg; ?>
<?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0){ ?>
<div class="Tabs">
<?php }else{ ?>
<div class="Tabs2">
<?php } ?>
    <ul class="tabs">
        <li><a href="#Roles" rel="0" title=".">ROLES +</a></li>
        <li><a href="#User-Details" rel="1" title="">CUENTA</a></li>
        <li><a href="#User-Profile" rel="2" title="">PERFIL</a></li>
        <li><a href="#Change-Password" rel="3" title="">CLAVE</a></li>
        <?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0){ ?>
        <li><a href="#Premium" rel="4" title=".">USUARIO PAGO</a></li>
        <?php } ?>
    </ul>
    <div class="tab_container">
        <div id="Roles" class="tab_content">
		<?php require_once(ROOT_PATH.'admin/modules/user_detail/new_role.html.php'); ?>
        </div>
        <div id="User-Details" class="tab_content">
		<?php require_once(ROOT_PATH.'admin/modules/user_detail/details.html.php'); ?>
        </div>
        <div id="User-Profile" class="tab_content">
		<?php require_once(ROOT_PATH.'admin/modules/user_detail/profile.html.php'); ?>
        </div>
        <div id="Change-Password" class="tab_content">
		<?php require_once(ROOT_PATH.'admin/modules/user_detail/password.html.php'); ?>
        </div>
        <?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0){ ?>
        <div id="Premium" class="tab_content">
		<?php require_once(ROOT_PATH.'admin/modules/user_detail/premium.html.php'); ?>
        </div>
        <?php } ?>
    </div>
</div>
<div class="clearBoth"></div>