<?php
// button javascript
$save_changes_js = "return confirm('Do you want to SAVE the CHANGE(S)?');";

// get include file
require_once(ROOT_PATH.'admin/modules/config/error_messages.php');

// ------------------------------------------------------------
// 1. DISPLAY CONFIGURATION FILE ON PAGE LOAD
// ------------------------------------------------------------
$filename = ROOT_PATH.'web.config.php';
$contents = file_get_contents($filename);

if(!$contents)
{
	echo $read_file_error;
}

// ------------------------------------------------------------
// 2. UPDATE CONFIGURATION FILE
// ------------------------------------------------------------
if(isset($_POST['submit']))
{
	if(isset($_POST['txbConfig']) && !empty($_POST['txbConfig']))
	{
		// save changes to file
		$changes = stripslashes($_POST['txbConfig']);
		$save = file_put_contents($filename,$changes);
		
		if($save)
		{
			echo $file_update_success_msg;
			$contents = file_get_contents($filename);
		}
		else
		{
			echo $file_update_error;
		}
	}
	else
	{
		echo $file_empty_error;
	}
}
?>