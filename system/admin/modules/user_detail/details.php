<?php
// ------------------------------------------------------------
// DISPLAY CURRENT USER INFO
// ------------------------------------------------------------
// get query string
$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);

// if id sent is ok
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	$user_id = $sent_id;
	
	$get_user_details = mysqli_query($conn, "SELECT * FROM users WHERE UserId = $user_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_user_details) == 1)
	{
		$row = mysqli_fetch_array($get_user_details);
		$user_name = $row['UserName'];
		$pw_display = '******';
		$pw = $row['Password'];
		$pw_question = $row['PasswordQuestion'];
		$pw_answer = $row['PasswordAnswer'];
		$email = $row['Email'];
		$destin_url = $row['DestinationUrl'];
		$is_approved = $row['IsApproved'];
		if($is_approved == 1){$checked1 = 'checked="checked"';}else{$checked1 = '';}
		$is_locked_out = $row['IsLockedOut'];
		if($is_locked_out == 1){$checked2 = 'checked="checked"';}else{$checked2 = '';}
		$create_date = $row['CreateDate'];
		$last_login_date = $row['LastLoginDate'];
		$last_login_ip = $row['LastLoginIP'];
		$last_password_change_date = $row['LastPasswordChangeDate'];
		$last_actvity_date = $row['LastActivityDate'];
		$last_lockout_date = $row['LastLockoutDate'];
		$last_unlock_date = $row['LastUnlockDate'];
		$comment = $row['Comment'];
		$is_owner = $row['IsOwner'];
		if($is_owner == 1){$checked3 = 'checked="checked"';}else{$checked3 = '';}
	}
}
?>
