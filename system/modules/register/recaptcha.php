<?php 
$txbEmptyUn = '';
$txbUserNameCheck = '';
$txbEmptyPw = '';
$txbEmptyConfirmPw = '';
$passwordMismatch = '';
$passwordTooShort = '';
$passwordNumber = '';
$passwordChar = '';
$userExist = '';
$userInPw = '';
$emailNotValid = '';
$txbEmptyEmail = '';
$txbEmptyQuestion = '';
$txbEmptyAnswer = '';
$txbInvalidCaptcha = '';
$username = '';
$email = '';
$question = '';
$answer = '';

require_once(ROOT_PATH.'modules/register/username_check.php');

// ------------------------------------------------------------
// ENVIO DE FORMA
// ------------------------------------------------------------
if(isset($_POST['btnSubmit']))
{
	// Recaptcha
	require_once(ROOT_PATH.'lib/recaptchalib.php');
	$privatekey = RECAPTCHA_PRIVATE_KEY;
	$resp = recaptcha_check_answer
	(
		$privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]
	);
	
	// ------------------------------------------------------------
	// ERORRES
	// ------------------------------------------------------------	
	require_once(ROOT_PATH.'modules/register/error_messages.php');
		
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
	// CAPTCHA NO VALIDO
	// ------------------------------------------------------------
	if (!$resp->is_valid) 
	{
		$txbInvalidCaptcha = $captcha_error;
		$emptyField_error = 1;
	}
	// ------------------------------------------------------------
	// CAPTCHA VALIDO
	// ------------------------------------------------------------
	else 
	{
		// ------------------------------------------------------------
		// REVISA CLAVE Y USUARIO
		// ------------------------------------------------------------
		require_once(ROOT_PATH.'modules/register/password_match.php');
		

		require_once(ROOT_PATH.'modules/register/password_requirements.php');
		

		require_once(ROOT_PATH.'modules/register/validate_email.php');
		

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

			require_once(ROOT_PATH.'connect/mysql.php');
			require_once(ROOT_PATH.'lib/hasher.fn.php');
	

			$username4db = mysqli_real_escape_string($conn, $txbUn);
			$email4db = mysqli_real_escape_string($conn, $txbEmail);

			$checkuser = mysqli_query($conn, "SELECT UserName, Email FROM users WHERE UserName = '$username4db' OR EMAIL = '$email4db'") 
			or die($checkUser_error);

			if(mysqli_num_rows($checkuser) == 0 && $passwordMatch_error == 0 && $emailValidate_error == 0 && $pwMinRequirements_error == 0)
			{

				$hashedPw = hashThis($txbPw);
				$ActivationKey = hashThis($txbUn);
				

				$adminApproval = BY_ADMIN_APPROVAL_ONLY;
				$instantApproval = INSTANT_ACCOUNT_APPROVAL;
				
				if($adminApproval == 1 && $instantApproval == 0)
				{
					$is_approved = 0;
				}
				
				if($adminApproval == 1 && $instantApproval == 1)
				{
					$is_approved = 0;
				}
				
				if($adminApproval == 0 && $instantApproval == 0)
				{
					$is_approved = 0;
				}
				
				if($adminApproval == 0 && $instantApproval == 1)
				{
					$is_approved = 1;
				}
				
--
				$createuser = mysqli_query($conn, "INSERT INTO users(UserName, Password, PasswordQuestion, PasswordAnswer, Email, IsApproved, CreateDate, LastActivityDate, ActivationKey) VALUES('$txbUn', '$hashedPw', '$txbQuestion', '$txbAnswer', '$txbEmail', $is_approved, NOW(), NOW(), '$ActivationKey')") 
				or die($createUser_error);
				// ------------------------------------------------------------
				
				if($createuser)
				{
					$lastInsertId = mysqli_insert_id($conn);
					$defaultRole = DEFAULT_ROLE;
					$defaultRoleId = DEFAULT_ROLE_ID;

					$addusertorole = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES ($lastInsertId, $defaultRoleId, '$defaultRole')") 
					or die($addUserToRole_error);

					if($adminApproval == 1)
					{
						echo $activation_pending_msg;
					}
					elseif($adminApproval == 0)
					{

						if($addusertorole && $instantApproval == 0)
						{
							require_once(ROOT_PATH.'modules/register/send_confirmation.php');
							echo $confirmEmail_msg;
						}

						elseif($addusertorole && $instantApproval == 1)
						{
							echo $confirmactivation_msg;
						}
					}
				}
				else
				{
					echo $displayBanner_error;
				}
			}

			elseif(mysqli_num_rows($checkuser) > 0)
			{
				$userExist = $userName_error;
				echo $displayBanner_error;
			}
		}
	}
	

	require_once(ROOT_PATH.'modules/register/empty_fields_check.php');
}
?>