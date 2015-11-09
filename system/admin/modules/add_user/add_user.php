<?php
// ------------------------------------------------------------
// ERROR MESSAGE VARIABLES
// ------------------------------------------------------------
$txbEmptyUn = '';
$txbEmptyPw = '';
$txbEmptyConfirmPw = '';
$passwordMismatch = '';
$passwordTooShort = '';
$passwordNumber = '';
$passwordChar = '';
$userExist = '';
$emailNotValid = '';
$txbEmptyEmail = '';
$txbEmptyQuestion = '';
$txbEmptyAnswer = '';
$txbInvalidCaptcha = '';
$txbUserNameCheck = '';

// ------------------------------------------------------------
// ENTERED VALUE VARIABLES
// ------------------------------------------------------------
$username = '';
$email = '';
$question = '';
$answer = '';

// ------------------------------------------------------------
// USER NAME CHECK SUBMIT
// ------------------------------------------------------------	
require_once(ROOT_PATH.'admin/modules/add_user/username_check.php');

// ------------------------------------------------------------
// REGISTER FORM SUBMIT
// ------------------------------------------------------------
if(isset($_POST['btnSubmit']))
{
	// ------------------------------------------------------------
	// MESSAGES, ERROR MESSAGES AND ERROR CODES
	// ------------------------------------------------------------	
	require_once(ROOT_PATH.'admin/modules/add_user/error_messages.php');
	
	// ------------------------------------------------------------
	// SET VARIABLES FOR SUBMITTED FORM VALUES and sanitize
	// ------------------------------------------------------------
	$txbUn = strip_tags(strtolower($_POST['txbUn']));
	$txbPw = strip_tags($_POST['txbPw']);
	$txbConfirmPw = strip_tags($_POST['txbConfirmPw']);
	$txbEmail = strtolower($_POST['txbEmail']);
	$txbQuestion = strip_tags($_POST['txbQuestion']);
	$txbAnswer = strip_tags($_POST['txbAnswer']);
	
	// ------------------------------------------------------------
	// CHECK PASSWORD AND CONFIRM PASSWORD MATCH
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'admin/modules/add_user/password_match.php');
	
	// ------------------------------------------------------------
	// CHECK PASSWORD MINIMUM REQUIREMENTS
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'admin/modules/add_user/password_requirements.php');
	
	// ------------------------------------------------------------
	// VALIDATE E-MAIL
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'admin/modules/add_user/validate_email.php');
	
	// ------------------------------------------------------------
	// CHECK IF TEXTBOXES ARE FILLED AND EVERYTHING VALIDATED
	// ------------------------------------------------------------
	if
	(
		!empty($txbUn) && 
		!empty($txbPw) && 
		!empty($txbConfirmPw) && 
		!empty($txbEmail) && 
		!empty($txbQuestion)&& 
		!empty($txbAnswer) && 
		$passwordMatch_error == 0 && 
		$emailValidate_error == 0 && 
		$pwMinRequirements_error == 0
	)
	{
		//------------------------------------------------------------
		// include db connection
		//------------------------------------------------------------
		require_once(ROOT_PATH.'connect/mysql.php');
		require_once(ROOT_PATH.'lib/hasher.fn.php');

		// ------------------------------------------------------------
		// SET VARIABLES FOR DB CHECK
		// ------------------------------------------------------------
		$username4db = mysqli_real_escape_string($conn, $txbUn);
		$email4db = mysqli_real_escape_string($conn, $txbEmail);
		
		// DB QUERY: check for DUPLICATE username and/or email - both must be unique
		// ------------------------------------------------------------
		$checkuser = mysqli_query($conn, "SELECT UserName, Email FROM users WHERE UserName = '$username4db' OR EMAIL = '$email4db'") 
		or die($checkUser_error);
		// ------------------------------------------------------------
		
		// if user name or email does NOT exist yet validation is ok
		if(mysqli_num_rows($checkuser) == 0 && $passwordMatch_error == 0 && $emailValidate_error == 0 && $pwMinRequirements_error == 0)
		{
			// create hashed password and activation key
			$hashedPw = hashThis($txbPw);
			$ActivationKey = hashThis($txbUn);
			
			if(isset($_POST['sendCredentials'])){$email_credentials = 1;}else{$email_credentials = 0;}
			if(isset($_POST['sendConfirmation'])){$email_confirmation = 1;}else{$email_confirmation = 0;}
			if(isset($_POST['activateAccount'])){$instantApproval = 1;}else{$instantApproval = 0;}
			if(isset($_POST['isOwner'])){$is_owner = 1;}else{$is_owner = 0;}
			
			// DB QUERY: CREATE new user but do not approve account
			// ------------------------------------------------------------
			$createuser = mysqli_query($conn, "INSERT INTO users(UserName, Password, PasswordQuestion, PasswordAnswer, Email, IsApproved, CreateDate, LastActivityDate, ActivationKey, IsOwner) VALUES('$txbUn', '$hashedPw', '$txbQuestion', '$txbAnswer', '$txbEmail', $instantApproval, NOW(), NOW(), '$ActivationKey', $is_owner)") 
			or die($createUser_error);
			// ------------------------------------------------------------
			
			if($createuser)
			{
				// get the last insert id
				$lastInsertId = mysqli_insert_id($conn);
				$defaultRole = DEFAULT_ROLE;
				$defaultRoleId = DEFAULT_ROLE_ID;
				$owner_role = 'owner';
				$owner_role_id = 1;
				
				if($is_owner == 0)
				{
					// DB QUERY: ADD NEW USER to DEFAULT ROLE
					// ------------------------------------------------------------
					$addusertorole = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES ($lastInsertId, $defaultRoleId, '$defaultRole')") 
					or die($addUserToRole_error);
					// ------------------------------------------------------------
				}
				if($is_owner == 1)
				{
					// DB QUERY: ADD NEW USER to OWNER ROLE
					// ------------------------------------------------------------
					$addusertorole = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES ($lastInsertId, $owner_role_id, '$owner_role')") 
					or die($addUserToRole_error);
					// ------------------------------------------------------------
				}
			
				// ------------------------------------------------------------
				// IF INSTANT APPROVAL IS NOT ON - SEND CONFIRMATION E-MAIL
				// ------------------------------------------------------------
				if($addusertorole && $instantApproval == 0)
				{
					require_once(ROOT_PATH.'admin/modules/add_user/send_confirmation.php');
					echo $confirmEmail_msg;
				}
				// ------------------------------------------------------------
				// OTHERWISE ONLY DISPLAY SUCCESS MESSAGE
				// ------------------------------------------------------------
				elseif($addusertorole && $instantApproval == 1)
				{
					if($email_credentials == 1)
					{
						require_once(ROOT_PATH.'admin/modules/add_user/send_credentials.php');
					}
					echo $userCreate_success_msg;
				}
			}
			else
			{
				echo $displayBanner_error;
			}
		}
		// ------------------------------------------------------------
		// IF USER NAME OR E-MAIL ALREADY EXIST
		// ------------------------------------------------------------
		elseif(mysqli_num_rows($checkuser) > 0)
		{
			$userExist = $userName_error;
			echo $displayBanner_error;
		}
	}
	
	// ------------------------------------------------------------
	// CHECK FOR EMPTY FIELDS
	// ------------------------------------------------------------
	require_once(ROOT_PATH.'admin/modules/add_user/empty_fields_check.php');
}
?>