<?php
// get required includes
require_once(ROOT_PATH.'admin/modules/download/error_messages.php');

// ------------------------------------------------------------
// CHECK IF PREMIUM MEMBERSHIP IS ENABLED IN WEB.CONFIG
// ------------------------------------------------------------
if(ENABLE_PREMIUM_MEMBERSHIP == 0)
{
	echo $premium_not_enabled;
}

// ------------------------------------------------------------
// TITLE TAGS FOR HTML FORM
// ------------------------------------------------------------
$is_enabled_title = 'If this option is not checked, the download link will not be displayed.';
$download_name_title = 'The name of the download that will be displayed to the user.';
$file_name_title = 'The name of the actual file. I.E. my_test_download.zip or my_image_download.png ect...';
$remaining_title = 'The number of times the file can be downloaded by the permitted user.';
$date_added_title = 'The date the file was uploaded.';
$date_modified_title = 'The last date the file details were modified.';
$premium_level_title = "This refers to the Premium Access Level that is assigned to each premium membership rate. For example: If a user buys a subscription with premium access level of 1, the user's Premium Access Level becomes 1 and he/she will be able to download files that have the access level of 1. <br/><br/>You can also use multiple values separated by a coma. Example: 0,1,2,3,4,5 etc... When multiple values are used, users from each of those access levels are able to download the file. Users who are not Premium Subscribers have the access level of zero (0).";

// declare variables
$msg = '';

// ------------------------------------------------------------
// UPDATE CURRENT DOWNLOAD DETAILS
// ------------------------------------------------------------
if(isset($_POST['btnUpdateDownload']))
{
	$sent_id = mysqli_real_escape_string($conn, $_GET['did']);
	if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
	{
		// establish sent id
		$download_id = $sent_id;
		
		// set conditions
		$validation_error = 0;
		
		// get enabled checkbox
		if(isset($_POST['is_enabled']))
		{
			$is_enabled = 1;
		}
		else
		{
			$is_enabled = 0;
		}
		
		// get premium level(s)
		if(isset($_POST['premium_levels']))
		{
			$sent_premium_levels = mysqli_real_escape_string($conn, trim($_POST['premium_levels']));

			/*
				/    # delimiter
				^    # match the beginning of the line
				\d   # match a digit
				(?:  # open a non-capturing group
				,    # match a comma
				\d   # match a digit
				)    # close the group
				*    # match the previous group zero or more times
				$    # match the end of the line
				/    # delimiter

				NOTE: to allow multiple digit numbers, use \d+
			*/
			if(preg_match('/^\d+(?:(?:,\d+)+)?$/', $sent_premium_levels))
			{
				$premium_level = $sent_premium_levels;
			}
			else
			{
				$msg .= $premium_level_not_numeric_msg;
				$validate_error = 1;
			}
		}
		else
		{
			$msg .= $premium_level_empty_msg;
			$validation_error = 1;
		}
		
		// get download name
		if(!empty($_POST['download_name']))
		{
			$download_name = mysqli_real_escape_string($conn,trim($_POST['download_name']));
		}
		else
		{
			$msg .= $download_name_empty_msg;
			$validation_error = 1;
		}
		
		// if form is valid
		if($validation_error == 0)
		{
			// update download info in database
			$update_download_details = mysqli_query($conn, "UPDATE downloads SET DownloadName = '$download_name', DateModified = NOW(), IsEnabled = $is_enabled, PremiumLevel = '$premium_level' WHERE DownloadId = $download_id")
			or die($dataaccess_error);
			
			if(mysqli_affected_rows($conn) > 0)
			{
				echo $download_update_success;
			}
			else
			{
				echo $no_changes;
			}
		}
	}
}

// ------------------------------------------------------------
// DISPLAY CURRENT DOWNLOAD DETAILS
// ------------------------------------------------------------
$sent_id = mysqli_real_escape_string($conn, $_GET['did']);
if(isset($sent_id) && !empty($sent_id) && is_numeric($sent_id) && $sent_id > 0)
{
	// establish sent id
	$download_id = $sent_id;
	
	$get_current_download = mysqli_query($conn, "SELECT DownloadName, FileName, DateAdded, DateModified, IsEnabled, PremiumLevel FROM downloads WHERE DownloadId = $download_id LIMIT 1")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_current_download) == 1 )
	{
		$row = mysqli_fetch_array($get_current_download);
		$download_name = $row['DownloadName'];
		$file_name = $row['FileName'];
		$date_added = $row['DateAdded'];
		$date_modified = $row['DateModified'];
		if($row['IsEnabled'] == 1)
		{
			$is_enabled = 1;
			$checked1 = 'checked="checked"';
		}
		else
		{
			$is_enabled = 0;
			$checked1 = '';
		}
		$premium_level = $row['PremiumLevel'];
	}
}
?>