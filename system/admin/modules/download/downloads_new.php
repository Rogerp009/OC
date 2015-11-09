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
$file_name_title = 'Select a file to upload to the protected downloads directory. Uploaded files are protected by a htaccess file from direct access.';
$remaining_title = 'The number of times the file can be downloaded by the permitted user.';
$premium_level_title = "This refers to the Premium Access Level that is assigned to each premium membership rate. For example: If a user buys a subscription with premium access level of 1, the user's Premium Access Level becomes 1 and he/she will be able to download files that have the access level of 1. <br/><br/>You can also use multiple values separated by a coma. Example: 0,1,2,3,4,5 etc... When multiple values are used, users from each of those access levels are able to download the file. Users who are not Premium Subscribers have the access level of zero (0).";

// declare variables
$msg = '';

// ------------------------------------------------------------
// ADD NEW DOWNLOAD
// ------------------------------------------------------------
if(isset($_POST['btnNewDownload']))
{
	$validate_error = 0;
	
	if(!empty($_FILES['fileUpload']['name']))
	{
		// create variables
		$upload_directory = DOWNLOAD_DIRECTORY;
		$file_name = $_FILES['fileUpload']['name'];
		$file_type = $_FILES['fileUpload']['type'];
		$file_size = $_FILES['fileUpload']['size'];
		$file_size_limit = MAX_UPLOAD_FILE_SIZE;
		$calc_kilobites = 10240;
		$file_size_kb = round($file_size / $calc_kilobites, 2);
		$temp_file_name = $_FILES['fileUpload']['tmp_name'];
		$upload_error = $_FILES['fileUpload']['error'];
		
		// create unique file name
		$unique_file_name = time().'-'.$file_name;
		
		// if upload error display error message
		if($upload_error > 0)
		{
			echo "<div class='msgBox2 noBorder'>ERROR:" . $upload_error . "</div>";
			exit();
		}
		
		// if no upload error - check for file types
		if($upload_error == 0)
		{
			// if file size is within limits
			if($file_size <= $file_size_limit)
			{
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
					$validate_error = 1;
				}
				
				// get download name
				if(!empty($_POST['download_name']))
				{
					$download_name = mysqli_real_escape_string($conn,trim($_POST['download_name']));
				}
				else
				{
					$msg .= $download_name_empty_msg;
					$validate_error = 1;
				}
				
				// if form is valid and file uploaded ok
				if($validate_error == 0 && move_uploaded_file($temp_file_name, $upload_directory . $unique_file_name))
				{
					// DB: add download info to database
					$insert_profile = mysqli_query($conn, "INSERT INTO downloads(DownloadName,FileName,DateAdded,DateModified,IsEnabled,PremiumLevel) VALUES('$download_name','$unique_file_name',NOW(),NOW(),$is_enabled,'$premium_level')") 
					or die($dataaccess_error);
					
					if(mysqli_affected_rows($conn) > 0)
					{
						echo $file_upload_success;
					}
				}
				else
				{
					echo $file_upload_failed;
				}
			}
			else
			{
				echo $upload_file_too_large;
			}
		}
	}
	else
	{
		echo $upload_file_empty;
	}
}
?>