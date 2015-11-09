<?php 

if(isset($_POST['btnAutoLogout']))
{
	require_once(ROOT_PATH.'delete_auto_login.php');
}

if(isset($_POST['btnLogout']))
{
	require_once(ROOT_PATH.'modules/logout/logout.php');
}

if(isset($_COOKIE['user'], $_COOKIE['pass']))
{
	echo "<input type='submit' name='btnAutoLogout' id='btnAutoLogout' value='Turn Off' class='btnLogout' title='Turn Off Auto Login' />";
}

if(!isset($_COOKIE['user'], $_COOKIE['pass']) && !empty($_SESSION['UserName']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	echo "<input type='submit' name='btnLogout' id='btnLogout' value='Desconectar' class='btnLogout' title='Desconectar' />";
}
?>