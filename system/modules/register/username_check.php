<?php

if(isset($_POST['btnCheckUn']))
{
	if(!empty($_POST['txbUn']))
	{

		$txbUn = strip_tags(strtolower($_POST['txbUn']));
		

		require_once(ROOT_PATH.'connect/mysql.php');
		require_once(ROOT_PATH.'modules/register/error_messages.php');
		
		// revisa usuario en la basededatos
		$usernamelookup = mysqli_real_escape_string($conn, $txbUn);
		$checkusername = mysqli_query($conn, "SELECT * FROM users WHERE UserName = '$usernamelookup'") 
		or die($checkUser_error);
		
		if(mysqli_num_rows($checkusername) > 0)
		{
			// no disponible
			echo $displayBanner_error;
			$txbUserNameCheck = $userNameNotAvailable_msg;
			$username = $txbUn;
		}
		else
		{
			$txbUserNameCheck = $userNameAvailable_msg;
			$username = $txbUn;
		}
	}
	else
	{
		require_once(ROOT_PATH.'modules/register/error_messages.php');
		$txbEmptyUn = $EmptyCheckUn_msg;
		echo $displayBanner_error;
	}
}
?>