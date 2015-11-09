<?php 

if(!isset($_SESSION)) {
  session_start();
}


if(isset($_COOKIE['user'], $_COOKIE['pass']))
{
	$autoLoginDays = (AUTO_LOGIN_DURATION / 86400);
	echo "<div class='msgBox3'><form id='frmAutoLogout' name='frmAutoLogout' method='post' action='' class='htmlForm'><input type='submit' name='btnAutoLogout' id='btnAutoLogout' value='Desactivar' class='btnRight' />Bienvenido, estaras conectado por ".$autoLoginDays." dias.</form> </div>";
	
	if(isset($_POST['btnAutoLogout']))
	{
		require_once(ROOT_PATH.'delete_auto_login.php');
	}
	exit();
}


if(!empty($_SESSION['UserName']) && !empty($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1)
{
	$username = $_SESSION['UserName'];
	echo "<div class='msgBox2'><form id='frmLogout' name='frmLogout' method='post' action='' class='htmlForm'><input type='submit' name='btnLogout' id='btnLogout' value='Salir' class='btnRight' />Bienvenido $username! Estas conectado. </form></div>";

	if(isset($_POST['btnLogout']))
	{
		require_once(ROOT_PATH.'modules/logout/logout.php');
	}
}
else
{
	require_once(ROOT_PATH.'modules/register/register.html.php');
}
?>