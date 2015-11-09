<?php // include files
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/user_dash/error_messages.php');
?>
<div class="infoBanner"><div class="inner">This page provides detailed statistical analysis of registered user accounts.</div></div>
<div class="infoBanner_shadow"></div>
<div class="chartsWrap">
	<?php require_once(ROOT_PATH.'admin/modules/user_dash/charts.php'); ?>
</div>
<?php if(ENABLE_PREMIUM_MEMBERSHIP == 1){ ?>
<div class="chartsWrap2">
  <div class="premiumHeader">Premium Membership</div>
  <div class="premiumWrap">
    <span class="premiumNum"><?php echo $premium_count; ?></span><br/>
    <span class="premiumTitle">Member Count:</span>
  </div>
  <div class="premiumWrap">
    <span class="premiumNum"><?php require_once(ROOT_PATH.'admin/modules/user_dash/premium_count_24.php'); ?></span><br/>
    <span class="premiumTitle">Signup - 24 Hrs:</span>
  </div>
  <div class="premiumWrap">
    <span class="premiumNum">$<?php require_once(ROOT_PATH.'admin/modules/user_dash/premium_sales_today.php'); ?></span><br/>
    <span class="premiumTitle">Sales - 24 Hrs:</span>
  </div>
  <div class="premiumWrap">
    <span class="premiumNum">$<?php require_once(ROOT_PATH.'admin/modules/user_dash/premium_total_sales.php'); ?></span><br/>
    <span class="premiumTitle">Total Sales:</span>
  </div>
  <div class="premiumWrap">
    <span class="premiumNum">$<?php require_once(ROOT_PATH.'admin/modules/user_dash/premium_sales_30.php'); ?></span><br/>
    <span class="premiumTitle">Last 30 Days:</span>
  </div>
  <div class="premiumWrap">
    <span class="premiumNum">$<?php require_once(ROOT_PATH.'admin/modules/user_dash/premium_sales_365.php'); ?></span><br/>
    <span class="premiumTitle">Last 1 Year:</span>
  </div>
  <div class="clearBoth"></div>
</div>
<?php } ?>
<div class="statsWrap">
    <ul class="ulLeft">
    	<li class="title">Latest Members</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/newest_members.php'); ?>
    </ul>
    <ul class="ulRight">
    	<li class="title">Membership Status</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/status_locked_out.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/status_unapproved.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/status_total.php'); ?>
    </ul>
    <div class="clearBoth height10"></div>
    <ul class="ulLeft">
    	<li class="title">Latest Logins</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/latest_logins.php'); ?>
    </ul>
    <ul class="ulRight">
    	<li class="title">Last Logged In</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/login_last_30.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/login_30_60.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/login_60_90.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/login_over_90.php'); ?>
    </ul>
    <div class="clearBoth height10"></div>
	<ul class="ulLeft">
    	<li class="title">Membership Registrations</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/registrations_last_30.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/registrations_30_60.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/registrations_60_90.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/registrations_over_90.php'); ?>
    </ul>
    <ul class="ulRight">
    	<li class="title">Roles</li>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/role_names.php'); ?>
        <?php require_once(ROOT_PATH.'admin/modules/user_dash/role_count.php'); ?>
    </ul>
    <div class="clearBoth"></div>
</div>