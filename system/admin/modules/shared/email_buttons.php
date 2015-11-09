<div class="buttonsWrap"> 
  <!-- buttons -->
  <input name="btnSendToSelected" type="submit" value="Send E-mail" class="gvbtn" title="Send E-MAIL to SELECTED users." onclick="<?php echo $send_to_selected_js; ?>" />
  <input name="btnSendToAll" type="submit" value="Send To All" class="gvbtn" title="Send E-MAIL to ALL users." onclick="<?php echo $send_to_all_js; ?>" />
  <!-- dropdown menus --> 
  <span class="gvSelect">
  <select name="ddlSendToSelected" title="E-MAIL ALL users in selected ROLE." onchange="<?php echo $send_to_selected_role_js; ?>">
    <option selected="selected">Send To Role</option>
    <?php require(ROOT_PATH.'admin/modules/shared/get_roles.php'); ?>
  </select>
  </span>
  <?php if(ENABLE_USER_PROFILES == 1) {?>
  <span class="gvSelect">
  <select name="ddlSendToSubscribers" title="Send E-MAIL to SELECTED SUBSCRIBERS." onchange="<?php echo $send_to_subscribers_js; ?>">
    <option selected="selected">Send To Subscribers</option>
    <option>Newsletter</option>
    <option>Promotional Offer</option>
  </select>
  </span>
  <?php } ?>
  <?php if(HIDE_PREMIUM_MEMBERSHIP_IN_ADMIN == 0) {?>
  <input name="btnSendToPremium" type="submit" value="Send To Premium" class="gvbtn" title="Send E-MAIL to ALL Premium Members." onclick="<?php echo $send_to_premium_js; ?>" />
  <?php } ?>
  <div class="clearBoth"></div>
</div>