<?php

if(!isset($_SESSION)){
  session_start();
}


$first_pass = 0; // sessions
$second_pass = 0; // password
$third_pass = 0; // role
$auth_cookie_UserId = 0; // authorized cookie UserId
$auth_sess_UserId = 0; // authorized session UserId


if(!isset($_COOKIE['user']) && empty($_SESSION['UserName']))
{
	$first_pass = 0;

	$return_url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	header('Location:'.SITE_URL.'login.php?ReturnURL='.$return_url);
	exit();
}


if(isset($_COOKIE['user'], $_COOKIE['pass']))
{

	require_once(ROOT_PATH.'connect/mysql.php');
	require_once(ROOT_PATH.'modules/login/error_messages.php');
	require_once(ROOT_PATH.'lib/hasher.fn.php');
	

	$usercookie = mysqli_real_escape_string($conn, $_COOKIE['user']);
	

	$cookie_auth = mysqli_query($conn, "SELECT UserId, UserName, Password, SessionId, PremiumLevel FROM users WHERE UserName = '$usercookie' AND IsApproved = 1 AND IsLockedOut = 0 LIMIT 1") 
	or die($dataaccess_error);
	// ------------------------------------------------------------
	
	if(mysqli_num_rows($cookie_auth) == 1)
	{
		$row = mysqli_fetch_array($cookie_auth);
		$auth_cookie_UserId = $row['UserId'];
		$check_pass = hashThis($row['Password']);
		$premium_user_name = $row['UserName'];
		$user_token = $row['SessionId'];
		

		if(ACCOUNT_SHARING == 0)
		{
			if($check_pass == $_COOKIE['pass'] && $user_token == $_COOKIE['cookie_auth_token'])
			{

				$second_pass = 1;
			}
			else
			{

				session_destroy();
				header('Location:'.SITE_URL.'login.php?TokenLogOff=1');
			}
		}
		

		if(ACCOUNT_SHARING == 1)
		{
			if($check_pass == $_COOKIE['pass'])
			{

				$second_pass = 1;
			}
		}
		
	}
}

//------------------------------------------------------------

if(!empty($_SESSION['UserName']) && !empty($_SESSION['Password']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	$first_pass = 1;

	if($first_pass == 1)
	{
		require_once(ROOT_PATH.'connect/mysql.php');
		require_once(ROOT_PATH.'modules/login/error_messages.php');
		require_once(ROOT_PATH.'lib/hasher.fn.php');
		
		$session_un = $_SESSION['UserName'];
		$session_pw = $_SESSION['Password'];

		if(isset($_SESSION['auth_token']))
		{
			$session_auth_token = $_SESSION['auth_token'];
		}
		
		$session_auth = mysqli_query($conn, "SELECT UserId, UserName, Password, SessionId, PremiumLevel FROM users WHERE UserName = '$session_un' AND IsApproved = 1 AND IsLockedOut = 0 LIMIT 1")
		or die($dataaccess_error);
		
		if(mysqli_num_rows($session_auth) == 1)
		{
			$row = mysqli_fetch_array($session_auth);
			$auth_sess_UserId = $row['UserId'];
			$auth_Password = hashThis($row['Password']);
			$premium_user_name = $row['UserName'];
			$user_token = $row['SessionId'];

			if(ACCOUNT_SHARING == 0)
			{
				if($auth_Password == $session_pw && $user_token == $session_auth_token)
				{
					$second_pass = 1;
				}
				else
				{
					session_destroy();		
					header('Location:'.SITE_URL.'login.php?TokenLogOff=1');
				}
			}

			if(ACCOUNT_SHARING == 1)
			{
				if($auth_Password == $session_pw)
				{
					$second_pass = 1;
				}
			}
		}
	}
}


if($second_pass == 1)
{

	$allowedRoles = "'" . implode("', '", $auth_roles) . "'";

	$auth_roles = mysqli_query($conn, "SELECT UserId, RoleId, RoleName FROM users_in_roles WHERE UserId IN ($auth_sess_UserId, $auth_cookie_UserId) AND RoleName IN ($allowedRoles)")
	or die($dataaccess_error);

	
	if(mysqli_num_rows($auth_roles) > 0)
	{

		$third_pass = 1;
	}
	else
	{
		$third_pass = 0;

		$return_url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		header('Location:'.SITE_URL.'login.php?clearance=failed&ReturnURL='.$return_url);
		exit();
	}
}


if($third_pass == 1 && ENABLE_PREMIUM_MEMBERSHIP == 1 && isset($premium_on) && $premium_on == 1)
{

	require_once(ROOT_PATH.'modules/authorization/premium_auth.php');
	
	if(!in_array($user_premium_level, $premium_access_levels))
	{
		$return_url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		header('Location:'.SITE_URL.'login.php?premium=failed&ReturnURL='.$return_url);
		exit();
	}
}
?>