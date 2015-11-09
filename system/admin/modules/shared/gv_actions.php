<?php
// get required includes
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/users_az/error_messages.php');

// ------------------------------------------------------------
// GRIDVIEW JAVASCRIPT
// ------------------------------------------------------------
// buttons
$delete_selected_js = "return confirm('DELETE the SELECTED user(s)?');";
$delete_all_users_js = "return confirm('WARNING! This action CANNOT be reversed. \\r\\nALL USERS and ALL Associated DATA and FILES will be DELETED.');";
$approve_selected_js = "return confirm('APPROVE the SELECTED user(s)?');";
$send_activation_js = "return confirm('Send Account Activation E-mail \\r\\nto SELECTED Unapproved USERS \\r\\nso they can CONFIRM their E-mail address \\r\\nand ACTIVATE their user account?');";
$approve_all_js = "return confirm('APPROVE ALL user(s)?');";
$unapprove_selected_js = "return confirm('UNAPPROVE the SELECTED user(s)?');";
$unapprove_all_js = "return confirm('UNAPPROVE ALL user(s)?');";
$unlock_js = "return confirm('UNLOCK the SELECTED user(s)?');";
$unlock_all_js = "return confirm('UNLOCK ALL user(s)?');";
$remove_all_from_all_js = "return confirm('REMOVE ALL users FROM ALL ROLES? NOTE: This will NOT DELETE the User Accounts.');";
// dropdown menus
$add_selected_js = "if(confirm('ADD Selected Users To SELECTED ROLE?'))form.submit();else return false;";
$add_all_js = "if(confirm('ADD ALL Users To SELECTED ROLE?'))form.submit();else return false;";
$remove_js = "if(confirm('REMOVE Selected Users FROM SELECTED ROLE?'))form.submit();else return false;";
$remove_all_js = "if(confirm('REMOVE ALL Users FROM SELECTED ROLE?'))form.submit();else return false;";
$delete_all_js = "if(confirm('DELETE All User Accounts PRESENT in the SELECTED ROLE?'))form.submit();else return false;";

// declare variables
$msg = '';

// ------------------------------------------------------------
// DELETE SELECTED USERS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteSelected']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	//$checked = array_map(function($s) use ($conn) { return mysqli_real_escape_string($conn, $s); }, $_POST['checked']);
	$delete_list = implode(", ", $checked);
	
	// 1. DB: delete user account
	$delete_selected = mysqli_query($conn, "DELETE FROM users WHERE UserId IN ($delete_list) AND NOT IsOwner = 1")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_users = mysqli_affected_rows($conn);
		
		// 2. DB: delete from roles
		$delete_from_roles = mysqli_query($conn, "DELETE FROM users_in_roles WHERE UserId IN ($delete_list) AND NOT RoleName = 'owner'")
		or die($dataaccess_error);
		
		$effected_roles = mysqli_affected_rows($conn);
		
		// 3. DB: delete from profiles
		$delete_from_profiles = mysqli_query($conn, "DELETE FROM profiles WHERE UserId IN ($delete_list)")
		or die($dataaccess_error);
		
		$effected_profiles = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_users) USER(S), ($effected_roles) ROLE(S), ($effected_profiles) PROFILE(S) have been DELETED..</div>";
	}
	elseif(mysqli_affected_rows($conn) == 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED USER(S) were DELETED...  </div>";
	}
}
elseif(isset($_POST['btnDeleteSelected']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// DELETE ALL USERS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteAll']))
{
	// 1. DB: delete user account
	$delete_all = mysqli_query($conn, "DELETE FROM users WHERE NOT IsOwner = 1")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_users = mysqli_affected_rows($conn);
		
		// 2. DB: delete from roles
		$delete_from_roles = mysqli_query($conn, "DELETE FROM users_in_roles WHERE NOT RoleName = 'owner'")
		or die($dataaccess_error);

		$effected_roles = mysqli_affected_rows($conn);
		
		// 3. DB: delete from profiles
		$delete_from_profiles = mysqli_query($conn, "DELETE FROM profiles")
		or die($dataaccess_error);

		$effected_profiles = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_users) USER(S), ($effected_roles) ROLE(S), ($effected_profiles) PROFILE(S) have been DELETED..</div>";
	}
}

// ------------------------------------------------------------
// APPROVE SELECTED USERS
// ------------------------------------------------------------
if(isset($_POST['btnApproveSelected']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	$approve_list = implode(", ", $checked);
	
	$approve_selected = mysqli_query($conn, "UPDATE users SET IsApproved = 1 WHERE UserId IN ($approve_list)")
	or die($dataaccess_error);
	
	if($approve_selected)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED USER(S) have been APPROVED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED USERS were ALREADY APPROVED. Transaction CANCELLED...</div>";
		}
	}
}
elseif(isset($_POST['btnApproveSelected']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// APPROVE ALL USERS
// ------------------------------------------------------------
if(isset($_POST['btnApproveAll']))
{
	$approve_all = mysqli_query($conn, "UPDATE users SET IsApproved = 1")
	or die($dataaccess_error);
	
	if($approve_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) USER(S) have been APPROVED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: ALL USERS were ALREADY APPROVED. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// SEND ACTIVATION EMAIL FOR UNAPPROVED ACCOUNTS
// ------------------------------------------------------------
if(isset($_POST['btnSendActivationEmail']) && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	$approve_list = implode(", ", $checked);
	
	// ------------------------------------------------------------
	// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
	// ------------------------------------------------------------
	$from_address = NO_REPLY;
	$activation_base_URL = ACCOUNT_ACTIVATION_URL;
	
	// ------------------------------------------------------------
	// ASSEMBLE ACTIVATION URL
	// ------------------------------------------------------------
	$get_user_details = mysqli_query($conn, "SELECT UserName, Email, ActivationKey FROM users WHERE UserId IN ($approve_list)")
	or die($dataaccess_error);
	
	$effected_rows = mysqli_num_rows($get_user_details);

	while($row = mysqli_fetch_array($get_user_details))
	{
		$email = $row['Email'];
		$activation_key = $row['ActivationKey'];
		$user_account = $row['UserName'];
	
		if(!empty($email))
		{
			$activation_code = $activation_key;
			$parameter = "?aid=";
			$verificationURL = $activation_base_URL.$parameter.$activation_code;
			
			// ------------------------------------------------------------
			// CREATE HTML E-MAIL
			// ------------------------------------------------------------
			$to = $email;
			$subject = 'Account Confirmation';
			$priority = 1;
			$message = '
			<html>
			<head>
				<title>Account Confirmation</title>
			</head>
			<body>
				<p>Hello '.$user_account.',</p>
				<p>To complete your registration process, please click on the link below to confirm and activate your account.</p>
				<p><a href="'.$verificationURL.'">'.$verificationURL.'</a></p>
			</body>
			</html>
			';
			
			// ------------------------------------------------------------
			// SET HEADERS FOR HTML MAIL
			// ------------------------------------------------------------
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Account Confirmation <'.$from_address.'>' . "\r\n";
			$headers .= 'X-Priority: '.$priority.'' . "\r\n";	
				
			// ------------------------------------------------------------
			// SEND E-MAIL
			// ------------------------------------------------------------
			$send_mail = mail($to, $subject, $message, $headers);

			if($send_mail)
			{
				$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED USER(S) have been E-MAILED the account activation URL..</div>";
			}
			else
			{
				$msg = "<div class='msgBox3'>ERROR: Oops! ERROR Sending E-mail..</div>";
			}
		}
	}
}
elseif(isset($_POST['btnSendActivationEmail']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// UNAPPROVE SELECTED USERS
// ------------------------------------------------------------
if(isset($_POST['btnUnApprove']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	$unapprove_list = implode(", ", $checked);
	
	$unapprove_selected = mysqli_query($conn, "UPDATE users SET IsApproved = 0 WHERE UserId IN ($unapprove_list) AND NOT IsOwner = 1")
	or die($dataaccess_error);
	
	if($unapprove_selected)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED USER(S) have been UNAPPROVED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED USERS were ALREADY UNAPPROVED. Transaction CANCELLED...</div>";
		}
	}
}
elseif(isset($_POST['btnUnApprove']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// UNAPPROVE ALL USERS
// ------------------------------------------------------------
if(isset($_POST['btnUnApproveAll']))
{
	$unapprove_all = mysqli_query($conn, "UPDATE users SET IsApproved = 0 WHERE NOT IsOwner = 1")
	or die($dataaccess_error);
	
	if($unapprove_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) USER(S) have been UNAPPROVED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: ALL USERS were ALREADY UNAPPROVED. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// UNLOCK SELECTED USERS
// ------------------------------------------------------------
if(isset($_POST['btnUnlock']) && isset($_POST['checked']))
{
    $checked = array_map('intval',$_POST['checked']);
	$unlock_list = implode(", ", $checked);
	
	$unlock_selected = mysqli_query($conn, "UPDATE users SET IsLockedOut = 0 WHERE UserId IN ($unlock_list)")
	or die($dataaccess_error);
	
	if($unlock_selected)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED USER(S) have been UNLOCKED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED USERS were ALREADY UNLOCKED. Transaction CANCELLED...</div>";
		}
	}
}
elseif(isset($_POST['btnUnlock']) && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// UNLOCK ALL USERS
// ------------------------------------------------------------
if(isset($_POST['btnUnlockAll']))
{
	$unlock_all = mysqli_query($conn, "UPDATE users SET IsLockedOut = 0")
	or die($dataaccess_error);
	
	if($unlock_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED USER(S) have been UNLOCKED..</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: SELECTED USERS were ALREADY UNLOCKED. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// REMOVE ALL USERS FROM ALL ROLE (ACCEPT OWNER)
// ------------------------------------------------------------
if(isset($_POST['btnRemoveAll']))
{
	$remove_all = mysqli_query($conn, "DELETE FROM users_in_roles WHERE NOT RoleName = 'owner'")
	or die($dataaccess_error);
	
	if($remove_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) RECORDS have been DELETED. Only the OWNER role REMAINS...</div>";
		}
		else
		{
			$msg = "<div class='msgBox4'>NOTE: There WERE NO USERS present in any ROLE. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// ADD SELECTED USERS TO SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Add To' && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlAddSelected']);
	
	$get_role_id = mysqli_query($conn, "SELECT RoleId, RoleName FROM roles WHERE RoleName = '$selected_role' Limit 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_role_id) == 1)
	{
		$row = mysqli_fetch_array($get_role_id);
		$role_id = $row['RoleId'];
		$role_name = $row['RoleName'];

		$i1=0;
		$i2=0;
		foreach($checked as $user_id)
		{
			$check_if_exist = mysqli_query($conn, "SELECT UserId, RoleId, RoleName FROM users_in_roles WHERE UserId = $user_id AND RoleId = $role_id AND RoleName = '$role_name' LIMIT 1")
			or die($dataaccess_error);
			
			if(mysqli_num_rows($check_if_exist) == 0)
			{
				$add_selected = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES($user_id, $role_id, '$role_name')")
				or die($dataaccess_error);

				$count1 = $i1++ + 1;
				$count2 = $i2;
				$msg = "<div class='msgBox3'>SUCCESS: ($count1) USERS have been ADDED to ($selected_role) ROLE - AND ($count2) ALREADY EXISTS</div>";
			}
			elseif(mysqli_num_rows($check_if_exist) == 1)
			{
				$count1 = $i1;
				$count2 = $i2++ +1;
				$msg = "<div class='msgBox4'>NOTE: ($count1) USERS have been ADDED to ($selected_role) ROLE - AND ($count2) ALREADY EXISTS</div>";
			}
		}
	}
}
elseif(isset($_POST['ddlAddSelected']) && $_POST['ddlAddSelected'] != 'Add To' && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// ADD ALL USERS TO SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['ddlAddAll']) && $_POST['ddlAddAll'] != 'Add All To')
{
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlAddAll']);
	
	$get_role_id = mysqli_query($conn, "SELECT RoleId, RoleName FROM roles WHERE RoleName = '$selected_role' Limit 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_role_id) == 1)
	{
		$row = mysqli_fetch_array($get_role_id);
		$role_id = $row['RoleId'];
		$role_name = $row['RoleName'];
		
		$get_all_users = mysqli_query($conn, "SELECT UserId FROM users")
		or die($dataaccess_error);
		
		if(mysqli_num_rows($get_all_users) > 0)
		{
			$i1=0;
			$i2=0;
			while($row = mysqli_fetch_array($get_all_users))
			{
				$user_id = $row['UserId'];
				
				$check_if_exist = mysqli_query($conn, "SELECT UserId, RoleId, RoleName FROM users_in_roles WHERE UserId = $user_id AND RoleId = $role_id AND RoleName = '$role_name' LIMIT 1")
				or die($dataaccess_error);
				
				if(mysqli_num_rows($check_if_exist) == 0)
				{
					$add_all_to = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES($user_id, $role_id, '$role_name')")
					or die($dataaccess_error);
					
					$count1 = $i1++ + 1;
					$count2 = $i2;
					$msg = "<div class='msgBox3'>SUCCESS: ($count1) USERS have been ADDED to ($selected_role) ROLE - AND ($count2) ALREADY EXISTS</div>";
				}
				if(mysqli_num_rows($check_if_exist) == 1)
				{
					$count1 = $i1;
					$count2 = $i2++ +1;
					$msg = "<div class='msgBox4'>NOTE: ($count1) USERS have been ADDED to ($selected_role) ROLE - AND ($count2) ALREADY EXISTS</div>";
				}
			}
		}
	}
}

// ------------------------------------------------------------
// REMOVE SELECTED USERS FROM SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['ddlRemove']) && $_POST['ddlRemove'] != 'Remove From' && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlRemove']);
	
	$get_role_id = mysqli_query($conn, "SELECT RoleId, RoleName FROM roles WHERE RoleName = '$selected_role' Limit 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_role_id) == 1)
	{
		$row = mysqli_fetch_array($get_role_id);
		$role_id = $row['RoleId'];
		$role_name = $row['RoleName'];

		$i1=0;
		$i2=0;
		foreach($checked as $user_id)
		{
			$check_if_exist = mysqli_query($conn, "SELECT UserId, RoleId, RoleName FROM users_in_roles WHERE UserId = $user_id AND RoleId = $role_id AND RoleName = '$role_name' LIMIT 1")
			or die($dataaccess_error);
			
			if(mysqli_num_rows($check_if_exist) > 0)
			{
				$add_selected = mysqli_query($conn, "DELETE FROM users_in_roles WHERE UserId = $user_id AND RoleId = $role_id AND RoleName = '$role_name' AND NOT RoleName = 'owner'")
				or die($dataaccess_error);

				$count1 = $i1++ + 1;
				$count2 = $i2;
				$msg = "<div class='msgBox3'>SUCCESS: ($count1) USERS have been REMOVED from ($selected_role) ROLE - AND ($count2) DID NOT EXIST</div>";
			}
			elseif(mysqli_num_rows($check_if_exist) == 0)
			{
				$count1 = $i1;
				$count2 = $i2++ +1;
				$msg = "<div class='msgBox4'>NOTE: ($count1) USERS have been REMOVED from ($selected_role) ROLE - AND ($count2) DID NOT EXIST</div>";
			}
		}
	}
}
elseif(isset($_POST['ddlRemove']) && $_POST['ddlRemove'] != 'Remove From' && !isset($_POST['checked']))
{
	$msg = $msg_error;
}

// ------------------------------------------------------------
// REMOVE ALL USERS FROM ALL ROLE (ACCEPT OWNER)
// ------------------------------------------------------------
if(isset($_POST['ddlRemoveAll']) && $_POST['ddlRemoveAll'] != 'Remove All From')
{
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlRemoveAll']);
	
	$remove_all = mysqli_query($conn, "DELETE FROM users_in_roles WHERE RoleName = '$selected_role' AND NOT RoleName = 'owner'")
	or die($dataaccess_error);
	
	if($remove_all)
	{
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) RECORDS have been REMOVED from $selected_role.</div>";
		}
		if(mysqli_affected_rows($conn) == 0)
		{
			$msg = "<div class='msgBox4'>NOTE: There WERE NO USERS present in any ROLE. Transaction CANCELLED...</div>";
		}
	}
}

// ------------------------------------------------------------
// DELETE ALL USER ACCOUNTS PRESENT IN SELECTED ROLE
// ------------------------------------------------------------
if(isset($_POST['ddlDeleteAll']) && $_POST['ddlDeleteAll'] != 'Delete All From')
{
	$selected_role = mysqli_real_escape_string($conn, $_POST['ddlDeleteAll']);
	
	$get_user_ids = mysqli_query($conn, "SELECT UserId FROM users_in_roles WHERE RoleName = '$selected_role' AND NOT RoleName = 'owner'")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_user_ids) > 0)
	{
		$i1=0;
		while($row = mysqli_fetch_array($get_user_ids))
		{
			$user_id = $row['UserId'];
			
			$delete_user = mysqli_query($conn, "DELETE FROM users WHERE UserId = $user_id AND NOT IsOwner = 1")
			or die($dataaccess_error);
			
			$delete_user = mysqli_query($conn, "DELETE FROM users_in_roles WHERE UserId = $user_id AND NOT RoleName = 'owner'")
			or die($dataaccess_error);
			
			$count1 = $i1++ + 1;
			$msg = "<div class='msgBox3'>SUCCESS: ($count1) USER ACCOUNTS have been DELETED that has been PRESENT IN ($selected_role) ROLE.</div>";
		}
	}
	if(mysqli_num_rows($get_user_ids) == 0)
	{
		$msg = "<div class='msgBox4'>NOTE: There WERE NO USERS present in the SELECTED ROLE. Transaction CANCELLED...</div>";
	}
}
?>