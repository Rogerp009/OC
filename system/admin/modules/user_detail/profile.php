<?php
// ------------------------------------------------------------
// CHECK IF MEMBERSHIP PROFILES ARE ENABLED IN WEB.CONFIG
// ------------------------------------------------------------
if(ENABLE_USER_PROFILES == 0)
{
	echo $profile_not_enabled;
}

// ------------------------------------------------------------
// DISPLAY CURRENT PROFILE INFO
// ------------------------------------------------------------
$msg = '';
$f_avatar_image = '';

// get query string
$sent_id = mysqli_real_escape_string($conn, $_GET['uid']);

// if id sent is ok
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	$user_id = $sent_id;
	
	$get_profile_details = mysqli_query($conn, "SELECT * FROM profiles WHERE UserId = $user_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_profile_details) == 1 )
	{
		$row = mysqli_fetch_array($get_profile_details);
		$f_first_name = $row['FirstName'];
		$f_last_name = $row['LastName'];
		$f_company_name = $row['CompanyName'];
		if($row['WebsiteUrl'] == '')
		{
			$f_website = 'http://'.$row['WebsiteUrl'];
		}
		else
		{
			$f_website = $row['WebsiteUrl'];
		}
		$f_profile_title = $row['ProfileTitle'];
		$f_profile_text = $row['ProfileText'];
		$f_phone = $row['Phone'];
		$f_address = $row['Address'];
		$f_street = $row['Street'];
		$f_city = $row['City'];
		$f_state = $row['State'];
		$f_zip_code = $row['Zip'];
		$f_country = $row['Country'];
		if($row['Newsletter'] == 1)
		{
			$newsletter = 1;
			$checked1 = 'checked="checked"';
		}
		else
		{
			$newsletter = 0;
			$checked1 = '';
		}
		if($row['Promotion'] == 1)
		{
			$promotion = 1;
			$checked2 = 'checked="checked"';
		}
		else
		{
			$promotion = 0;
			$checked2 = '';
		}
	}
	elseif(mysqli_num_rows($get_profile_details) == 0 )
	{
		$f_first_name = '';
		$f_last_name = '';
		$f_company_name = '';
		$f_website = 'http://';
		$f_profile_title = '';
		$f_profile_text = '';
		$f_phone = '';
		$f_address = '';
		$f_street = '';
		$f_city = '';
		$f_state = '';
		$f_zip_code = '';
		$f_country = '';
		$newsletter = 0;
		$promotion = 0;
	}
}

// ------------------------------------------------------------
// DISPLAY CURRENT AVATAR ON PAGE LOAD
// ------------------------------------------------------------
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	$user_id = $sent_id;
	
	// get user id
	$get_avatar_image = mysqli_query($conn, "SELECT AvatarImage FROM profiles WHERE UserId = $user_id Limit 1") 
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_avatar_image) == 1)
	{
		$row = mysqli_fetch_array($get_avatar_image);
		if($row['AvatarImage'] != 'NULL' && $row['AvatarImage'] != '')
		{
			$f_avatar_image = $row['AvatarImage'];
		}
		else
		{
			$f_avatar_image = AVATAR_IMAGE_URL.DEFAULT_AVATAR_IMAGE;
		}
	}
	else
	{
		$f_avatar_image = AVATAR_IMAGE_URL.DEFAULT_AVATAR_IMAGE;
	}
}
?>