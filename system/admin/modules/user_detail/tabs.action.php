<?php
// get required includes
require_once(ROOT_PATH.'connect/mysql.php');
require_once(ROOT_PATH.'admin/modules/user_detail/error_messages.php');
require_once(ROOT_PATH.'lib/hasher.fn.php');

// declare variables
$msg = '';

$passwordQ_msg = '';;
$passwordA_msg = '';
$email_msg = '';

$pw_empty = '';
$pw_match = '';
$pw_length = '';
$pw_special = '';
$pw_numeric = '';

$un_empty = '';
$un_match = '';
$un_exist = '';

// ------------------------------------------------------------
// CREATE NEW ROLE - TAB 1
// ------------------------------------------------------------
if(isset($_POST['NewRole']))
{
	if(!empty($_POST['role']))
	{
		$new_role = mysqli_real_escape_string($conn, $_POST['role']);
		
		// check if role exists
		$check_if_exist = mysqli_query($conn, "SELECT * FROM roles WHERE RoleName = '$new_role'")
		or die($dataaccess_error);
		
		if(mysqli_num_rows($check_if_exist) == 0)
		{
			// add new role
			$new_role = mysqli_query($conn, "INSERT INTO roles(RoleName, Description) VALUES('$new_role','not provided...')")
			or die($dataaccess_error);
			
			$msg = $role_success;
		}
		elseif(mysqli_num_rows($check_if_exist) == 1)
		{
			$msg = $role_exist_error;
		}
	}
	else
	{
		$msg = $new_role_error;
	}
}

// ------------------------------------------------------------
// UPDATE USER INFO - TAB 2
// ------------------------------------------------------------
if(isset($_POST['UpdateUser']))
{
	// get user id from query string sent
	$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		$user_id = $sent_id;

		// ------------------------------------------------------------
		// UPDATE USER ROLES
		// ------------------------------------------------------------
		if(isset($_POST['checked']))
		{
			// first delete user from all roles
			$delete_user_from_roles = mysqli_query($conn, "DELETE FROM users_in_roles WHERE UserId = $user_id")
			or die($dataaccess_error);
			
			// get selected role names
			$checked = $_POST['checked'];

			foreach($checked as $role_name)
			{
				// get role id
				$get_role_id = mysqli_query($conn, "SELECT RoleId FROM roles WHERE RoleName = '$role_name'")
				or die($dataaccess_error);
				
				$row = mysqli_fetch_array($get_role_id);
				$role_id = $row['RoleId'];
				
				$check_if_exist = mysqli_query($conn, "SELECT UserId, RoleId, RoleName FROM users_in_roles WHERE UserId = $user_id AND RoleId = $role_id AND RoleName = '$role_name' LIMIT 1")
				or die($dataaccess_error);
				
				if(mysqli_num_rows($check_if_exist) == 0)
				{
					// add user to roles
					$add_user_to_roles = mysqli_query($conn, "INSERT INTO users_in_roles(UserId, RoleId, RoleName) VALUES($user_id, $role_id, '$role_name')")
					or die($dataaccess_error);
					
					$msg = $user_update_success;
				}
			}
		}
		else
		{
			$msg = $msg_error2;
		}
		
		if(isset($_POST['checked']))
		{
			// ------------------------------------------------------------
			// UPDATE USER INFO 
			// ------------------------------------------------------------
			
			// set conditions
			$validation_error = 0;
			
			// validate password Q input
			if(!empty($_POST['passwordQ']))
			{
				$password_question = mysqli_real_escape_string($conn,$_POST['passwordQ']);
			}
			else
			{
				$passwordQ_msg = $passwordQ_error;
				$validation_error = 1;
			}
			
			// validate password A input	
			if(!empty($_POST['passwordA']))
			{
				$password_answer = mysqli_real_escape_string($conn,$_POST['passwordA']);
			}
			else
			{
				$passwordA_msg = $passwordA_error;
				$validation_error = 1;
			}
			
			// validate email input
			if(!empty($_POST['email']))
			{
				$email = mysqli_real_escape_string($conn,$_POST['email']);
				if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$email_msg = $email_invalid_error;
					$validation_error = 1;
				}
			}
			else
			{
				$email_msg = $email_error;
				$validation_error = 1;
			}
			
			// validate destination url input
			if(!empty($_POST['destinationUrl']))
			{
				$trimmed = trim($_POST['destinationUrl']," ");
				if(strlen($trimmed) > 0)
				{
					$destination = mysqli_real_escape_string($conn, $trimmed);
				}
				else
				{
					$destination = 'default';
				}
			}
			elseif(empty($_POST['destinationUrl']))
			{
				$destination = 'default';
			}
				
			// validate approved checkbox
			if(isset($_POST['approved']))
				$is_approved = 1;
			else
				$is_approved = 0;
				
			// validate lockedout checkbox
			if(isset($_POST['IsLockedOut']))
				$is_locked_out = 1;
			else
				$is_locked_out = 0;
				
			// validate comment input
			if(isset($_POST['comment']))
			{
				$comment = mysqli_real_escape_string($conn,$_POST['comment']);
			}
			else
			{
				$comment_msg = $comment_error;
				$validation_error = 1;
			}
			
			// validate owner checkbox
			if(isset($_POST['owner']))
				$is_owner = 1;
			else
				$is_owner = 0;
				
			// update user info
			if($validation_error == 0)
			{
				$check_if_email_exist = mysqli_query($conn, "SELECT EMAIL FROM users WHERE Email = '$email'")
				or die($dataaccess_error);
				
				if(mysqli_num_rows($check_if_email_exist) == 0)
				{
					$update_user_info = mysqli_query($conn, "UPDATE users SET PasswordQuestion = '$password_question', PasswordAnswer = '$password_answer', Email = '$email', DestinationUrl = '$destination', IsApproved = $is_approved, IsLockedOut = $is_locked_out, Comment = '$comment', IsOwner = $is_owner WHERE UserId = $user_id")
					or die($dataaccess_error);
	
					$msg = $user_update_success;
				}
				if(mysqli_num_rows($check_if_email_exist) == 1)
				{
					$update_user_info = mysqli_query($conn, "UPDATE users SET PasswordQuestion = '$password_question', PasswordAnswer = '$password_answer', DestinationUrl = '$destination', IsApproved = $is_approved, IsLockedOut = $is_locked_out, Comment = '$comment', IsOwner = $is_owner WHERE UserId = $user_id")
					or die($dataaccess_error);
	
					$msg = $email_exist_success;
				}
			}
			else
			{
				$msg = $user_update_error;
			}
		}
	}
}

// ------------------------------------------------------------
// UPDATE USER PROFILE - TAB 3
// ------------------------------------------------------------
if(isset($_POST['btnSaveProfile']))
{
	$validate_error = 0;
	
	// check for field values
	if(!empty($_POST['FirstName']))
	{
		$first_name = mysqli_real_escape_string($conn, trim($_POST['FirstName']));
	}
	else
	{
		$first_name = '';
	}
	
	if(!empty($_POST['LastName']))
	{
		$last_name = mysqli_real_escape_string($conn, trim($_POST['LastName']));
	}
	else
	{
		$last_name = '';
	}
	
	if(!empty($_POST['CompanyName']))
	{
		$company_name = mysqli_real_escape_string($conn, trim($_POST['CompanyName']));
	}
	else
	{
		$company_name = '';
	}
	
	if(!empty($_POST['Website']))
	{
		$website = mysqli_real_escape_string($conn, trim($_POST['Website']));
	}
	else
	{
		$website = '';
	}
	
	if(!empty($_POST['ProfileTitle']))
	{
		$profile_title = mysqli_real_escape_string($conn, trim($_POST['ProfileTitle']));
	}
	else
	{
		$profile_title = '';
	}
	
	if(!empty($_POST['ProfileText']))
	{
		$profile_text = mysqli_real_escape_string($conn, trim($_POST['ProfileText']));
	}
	else
	{
		$profile_text = '';
	}
	
	if(!empty($_POST['Phone']))
	{
		$phone = mysqli_real_escape_string($conn, trim($_POST['Phone']));
	}
	else
	{
		$phone = '';
	}
	
	if(!empty($_POST['Address']))
	{
		$address = mysqli_real_escape_string($conn, trim($_POST['Address']));
	}
	else
	{
		$address = '';
	}
	
	if(!empty($_POST['Street']))
	{
		$street = mysqli_real_escape_string($conn, trim($_POST['Street']));
	}
	else
	{
		$street = '';
	}
	
	if(!empty($_POST['City']))
	{
		$city = mysqli_real_escape_string($conn, trim($_POST['City']));
	}
	else
	{
		$city = '';
	}
	
	if(!empty($_POST['State']))
	{
		$state = mysqli_real_escape_string($conn, trim($_POST['State']));
	}
	else
	{
		$state = '';
	}
	
	if(!empty($_POST['Zip']))
	{
		$zip_code = mysqli_real_escape_string($conn, trim($_POST['Zip']));
	}
	else
	{
		$zip_code = '';
	}
	
	if(!empty($_POST['Country']))
	{
		$country = mysqli_real_escape_string($conn, trim($_POST['Country']));
	}
	else
	{
		$country = '';
	}
	
	if(isset($_POST['Newsletter']))
	{
		$newsletter = 1;
	}
	else
	{
		$newsletter = 0;
	}
	
	if(isset($_POST['Promotion']))
	{
		$promotion = 1;
	}
	else
	{
		$promotion = 0;
	}

	// get user id from query string sent
	$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		$user_id = $sent_id;

		// get user name
		$get_user_name = mysqli_query($conn, "SELECT UserName FROM users WHERE UserId = $user_id Limit 1") 
		or die($dataaccess_error);
		
		// if user profile exist - update
		if(mysqli_num_rows($get_user_name) == 1 )
		{
			$row = mysqli_fetch_array($get_user_name);
			$user_name = $row['UserName'];
		
			// check if user profile already exist
			$check_user_profile = mysqli_query($conn, "SELECT UserId FROM profiles WHERE UserId = $user_id Limit 1") 
			or die($dataaccess_error);
			
			// if user profile exist - update
			if(mysqli_num_rows($check_user_profile) == 1 )
			{
				// update profiles
				$update_profile = mysqli_query($conn, "UPDATE profiles SET UserName = '$user_name', FirstName = '$first_name', LastName = '$last_name', CompanyName = '$company_name', WebSiteUrl = '$website', ProfileTitle = '$profile_title', ProfileText = '$profile_text', Phone = '$phone', Address = '$address', Street = '$street', City = '$city', State = '$state', Zip = '$zip_code', Country = '$country', Newsletter = $newsletter, Promotion = $promotion WHERE UserId = $user_id") 
				or die($dataaccess_error);
				
				if(mysqli_affected_rows($conn) > 0)
				{
					$msg = $profile_update_success;
				}
				else
				{
					$msg = $profile_update_failed;
				}
			}
			else
			{
				// create profile
				$insert_profile = mysqli_query($conn, "INSERT INTO profiles(UserId,UserName,FirstName,LastName,CompanyName,WebsiteUrl,ProfileTitle,ProfileText,Phone,Address,Street,City,State,Zip,Country,Newsletter,Promotion) VALUES($user_id,'$user_name','$first_name','$last_name','$company_name','$website','$profile_title','$profile_text','$phone','$address','$street','$city','$state','$zip_code','$country',$newsletter,$promotion)") 
				or die($dataaccess_error);
				
				if(mysqli_affected_rows($conn) > 0)
				{
					$msg = $profile_update_success;
				}
				else
				{
					$msg = $profile_create_failed;
				}
			}
		}
	}
}

// ------------------------------------------------------------
// DELETE USER PROFILE - TAB 3
// ------------------------------------------------------------
if(isset($_POST['btnDeleteProfile']))
{
	// get user id from query string sent
	$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		$user_id = $sent_id;
		
		// check if user profile exist
		$check_user_profile = mysqli_query($conn, "SELECT UserId FROM profiles WHERE UserId = $user_id Limit 1") 
		or die($dataaccess_error);
		
		// if user profile exist - delete
		if(mysqli_num_rows($check_user_profile) == 1 )
		{
			// check if user profile exist
			$delete_profile = mysqli_query($conn, "DELETE FROM profiles WHERE UserId = $user_id") 
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				echo $profile_delete_success;
			}
		}
		else
		{
			$msg = $profile_not_exist;
		}
	}
}

// ------------------------------------------------------------
// UPLOAD AVATAR - TAB 3
// ------------------------------------------------------------
if(isset($_POST['btnUploadAvatar']) && !empty($_FILES['fileUpload']['name']))
{
	// get user id from query string sent
	$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		$user_id = $sent_id;
		
		// get user name - we'll need it later
		$get_user_name = mysqli_query($conn, "SELECT UserName FROM users WHERE UserId = $user_id Limit 1") 
		or die($dataaccess_error);
		
		// if user name exist
		if(mysqli_num_rows($get_user_name) == 1 )
		{
			$row = mysqli_fetch_array($get_user_name);
			$user_name = $row['UserName'];
			
			// create variables
			$avatar_directory = AVATAR_FILE_DIRECTORY;
			$file_name = $_FILES['fileUpload']['name'];
			$file_type = $_FILES['fileUpload']['type'];
			$file_size = $_FILES['fileUpload']['size'];
			$file_size_limit = AVATAR_FILE_SIZE;
			$calc_kilobites = 1024;
			$file_size_kb = round($file_size / $calc_kilobites, 2);
			$temp_file_name = $_FILES['fileUpload']['tmp_name'];
			$upload_error = $_FILES['fileUpload']['error'];
			
			// create unique file name
			$unique_file_name = $user_name.'-'.$file_name;
			$avatar_img_url = AVATAR_IMAGE_URL.$unique_file_name;
			
			// if upload error display error message
			if($upload_error > 0)
			{
				echo "<div class='msgBox2 noBorder'>ERROR:" . $upload_error . "</div>";
			}
			
			// if no upload error - check for file types
			if($upload_error == 0 && 
			$file_type == 'image/gif' || 
			$file_type == 'image/jpeg' || 
			$file_type == 'image/png' )
			{
				// if file size is within limits
				if($file_size <= $file_size_limit)
				{
					// move uploaded file to assigned directory
					if(move_uploaded_file($temp_file_name, $avatar_directory . $unique_file_name))
					{
						// check if user profile already exist
						$check_user_profile = mysqli_query($conn, "SELECT UserId FROM profiles WHERE UserId = $user_id Limit 1") 
						or die($dataaccess_error);
						
						// if user profile exist - update
						if(mysqli_num_rows($check_user_profile) == 1 )
						{
							// update profiles
							$update_profile = mysqli_query($conn, "UPDATE profiles SET AvatarImage = '$avatar_img_url' WHERE UserId = $user_id") 
							or die($dataaccess_error);
							
							if(mysqli_affected_rows($conn) > 0)
							{
								echo 'Upload Success! <br/>';
								echo 'File Name: '.$file_name.'<br/>';
								echo 'File Type: '.$file_type.'<br/>';
								echo 'File Size: '.$file_size_kb.' Kb <br/>';
								$msg = $profile_update_success;
							}
							else
							{
								$msg = $profile_update_failed;
							}
						}
						else
						{
							// create profile
							$insert_profile = mysqli_query($conn, "INSERT INTO profiles(UserId,UserName,AvatarImage) VALUES($user_id,'$user_name','$avatar_img_url')") 
							or die($dataaccess_error);
							
							if(mysqli_affected_rows($conn) > 0)
							{
								echo 'Upload Success! <br/>';
								echo 'File Name: '.$file_name.'<br/>';
								echo 'File Type: '.$file_type.'<br/>';
								echo 'File Size: '.$file_size_kb.' Kb <br/>';
								$msg = $profile_update_success;
							}
							else
							{
								$msg = $profile_create_failed;
							}
						}
					}
					else
					{
						$msg = $avatar_upload_failed;
					}
				}
				else
				{
					$msg = $avatar_file_too_large;
				}
			}
			else
			{
				$msg = $avatar_wrong_file_type;
			}
		}
	}
}
if(isset($_POST['btnUploadAvatar']) && empty($_FILES['fileUpload']['name']))
{
	$msg = $avatar_empty;
}

// ------------------------------------------------------------
// UPDATE USER PASSWORD - TAB 4
// ------------------------------------------------------------
if(isset($_POST['UpdatePw']))
{
	$validate_error = 0;

	if(!empty($_POST['password']) && !empty($_POST['password2']))
	{
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
		
		if(isset($_POST['emailPw']))
		{
			$email_pw = 1;
		}
		else
		{
			$email_pw = 0;
		}
		
		if($password == $password2)
		{
			$length = strlen($password);
			$minpasswordlength = MIN_PASSWORD_LENGTH;
			if($length >= $minpasswordlength)
			{
				$requirenumber = REQUIRE_NUMBER;
				if($requirenumber == 1)
				{
					preg_match_all('/[0-9]/', $password, $numbers);
					$minonenumber = count($numbers[0]);
					if($minonenumber < 1)
					{
						$validate_error = 1;
						$msg = $password_numeric_error;
						$pw_numeric = $pw_numeric_msg;
					}
				}
				
				$requirespecialchar = REQUIRE_SPECIAL_CHAR;
				if($requirespecialchar == 1)
				{
					preg_match_all('/[|!@#$%&*\/=?,;.:\-_+~^\\\]/', $password, $specialchars);
					$minoneuniquechar = count($specialchars[0]);
					if($minoneuniquechar < 1)
					{
						$validate_error = 1;
						$msg = $password_special_error;
						$pw_special = $pw_special_msg;
					}
				}
				
				if($validate_error == 0)
				{
					$hashedPw = hashThis($password);
					$user_id = mysqli_real_escape_string($conn, $_GET['uid']);
					
					$reset_password = mysqli_query($conn, "UPDATE users SET Password = '$hashedPw' WHERE UserId = $user_id") 
					or die($createUser_error);
					
					if(mysqli_affected_rows($conn) > 0)
					{
						if($email_pw == 1)
						{
							require_once('email_pw.php');
						}
						else
						{
							$msg = $pw_reset_success1;
						}
					}
				}
			}
			else
			{
				$validate_error = 1;
				$msg = $password_length_error;
				$pw_length = $pw_length_msg;
			}
		}
		else
		{
			$validate_error = 1;
			$msg = $password_match_error;
			$pw_match = $pw_match_msg;
		}
	}
	else
	{
		$validate_error = 1;
		$msg = $password_empty_error;
		$pw_empty = $pw_empty_msg;
	}
}

// ------------------------------------------------------------
// UPDATE USER NAME - TAB 4
// ------------------------------------------------------------
if(isset($_POST['UpdateUn']))
{
	$validate_error = 0;
	
	if(!empty($_POST['userName']) && !empty($_POST['userName2']))
	{
		$user_name = mysqli_real_escape_string($conn, $_POST['userName']);
		$user_name2 = mysqli_real_escape_string($conn, $_POST['userName2']);
		if(isset($_POST['emailUn']))
		{
			$email_un = 1;
		}
		else
		{
			$email_un = 0;
		}
		
		if($user_name == $user_name2)
		{
			$user_id = mysqli_real_escape_string($conn, $_GET['uid']);
			
			$check_if_exist = mysqli_query($conn, "SELECT UserName FROM users WHERE UserName = '$user_name'") 
			or die($createUser_error);
			
			if(mysqli_num_rows($check_if_exist) == 0)
			{
				if($validate_error == 0)
				{
					// 1. DB: update user table
					$reset_username = mysqli_query($conn, "UPDATE users SET UserName = '$user_name' WHERE UserId = $user_id") 
					or die($user_update_error);
					
					if(mysqli_affected_rows($conn) > 0)
					{
						// 2. DB: update profiles table
						$update_profiles = mysqli_query($conn, "UPDATE profiles SET UserName = '$user_name' WHERE UserId = $user_id") 
						or die($profile_update_error);
						
						if($email_un == 1)
						{
							require_once('email_un.php');
						}
						else
						{
							$msg = $un_reset_success1;
						}
					}
				}
			}
			else
			{
				$validate_error = 1;
				$msg = $username_exist_error;
				$un_exist = $un_exist_msg;
			}
		}
		else
		{
			$validate_error = 1;
			$msg = $username_match_error;
			$un_match = $un_match_msg;
		}
	}
	else
	{
		$validate_error = 1;
		$msg = $username_empty_error;
		$un_empty = $un_empty_msg;
	}
}
// ------------------------------------------------------------
// UPDATE PREMIUM MEMBERSHIP - TAB 5
// ------------------------------------------------------------
if(isset($_POST['UpdatePremium']))
{
	$validate_error = 0;
	
	// get user id from query string sent
	$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);
	
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		$user_id = $sent_id;
		
		// check for field values
		if(isset($_POST['is_premium']))
		{
			$is_premium = 1;
		}
		else
		{
			$is_premium = 0;
		}
			
		if(!empty($_POST['premium_types']))
		{
			$membership_type = mysqli_real_escape_string($conn, trim($_POST['premium_types']));
		}
		else
		{
			$membership_type = 'Free Membership';
		}
		
		if(!empty($_POST['premium_start']))
		{
			$premium_start_date = mysqli_real_escape_string($conn, trim($_POST['premium_start']));
		}
		else
		{
			$premium_start_date = '0000-00-00 00:00:00';
		}
		
		if(!empty($_POST['premium_end']))
		{
			$premium_end_date = mysqli_real_escape_string($conn, trim($_POST['premium_end']));
		}
		else
		{
			$premium_end_date = '0000-00-00 00:00:00';
		}
		
		if(!empty($_POST['premium_amount']))
		{
			$premium_amount = mysqli_real_escape_string($conn, trim($_POST['premium_amount']));
		}
		else
		{
			$premium_amount = '0.00';
		}
		
		if(isset($_POST['is_pending']))
		{
			$is_pending = 1;
		}
		else
		{
			$is_pending = 0;
		}
		
		if(!empty($_POST['pending_date']))
		{
			$pending_date = mysqli_real_escape_string($conn, trim($_POST['pending_date']));
		}
		else
		{
			$pending_date = '0000-00-00 00:00:00';
		}

		if(isset($_POST['is_cancelled']))
		{
			$is_cancelled = 1;
		}
		else
		{
			$is_cancelled = 0;
		}
		
		if(!empty($_POST['cancelled_date']))
		{
			$cancelled_date = mysqli_real_escape_string($conn, trim($_POST['cancelled_date']));
		}
		else
		{
			$cancelled_date = '0000-00-00 00:00:00';
		}
		
		if(isset($_POST['is_end_of_term']))
		{
			$is_end_of_term = 1;
		}
		else
		{
			$is_end_of_term = 0;
		}
		
		if(!empty($_POST['eot_date']))
		{
			$eot_date = mysqli_real_escape_string($conn, trim($_POST['eot_date']));
		}
		else
		{
			$eot_date = '0000-00-00 00:00:00';
		}
		
		if(!empty($_POST['premium_levels']))
		{
			if(is_numeric($_POST['premium_levels']) && $_POST['premium_levels'] >= 0)
			{
				$premium_level = mysqli_real_escape_string($conn, trim($_POST['premium_levels']));
			}
			else
			{
				$validate_error = 1;
				$msg = $premium_level_not_numeric_error;
			}
		}
		else
		{
			$premium_level = 0;
		}
		
		if($validate_error == 0)
		{
			$update_user_info = mysqli_query($conn, "UPDATE users SET IsPremium = $is_premium, PremiumType = '$membership_type', PremiumStartDate = '$premium_start_date', PremiumEndDate = '$premium_end_date', PremiumAmount = $premium_amount, IsPending = $is_pending, PendingDate = '$pending_date', IsCancelled = $is_cancelled, CancelledDate = '$cancelled_date', IsEndOfTerm = $is_end_of_term, EndOfTermDate = '$eot_date', PremiumLevel = $premium_level WHERE UserId = $user_id")
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				$msg = $premium_update_success;
			}
			else
			{
				$msg = $premium_no_changes;
			}
		}
	}
}
?>