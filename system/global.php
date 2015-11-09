<?php

if(!isset($_SESSION)){
  session_start();
}
	
require_once('web.config.php'); 


if(ENABLE_VISITOR_COUNT == 1)
{

	require_once(ROOT_PATH.'/oc/system/connect/mysql.php'); 
	

	if(!isset($_SESSION['UniqueCounter']) || empty($_SESSION['UniqueCounter']))
	{
		$_SESSION['UniqueCounter'] = 1;
		
		$visitor_ip = $_SERVER['REMOTE_ADDR'];
		
		// ------------------------------------------------------------
		$add_count = mysqli_query($conn, "INSERT INTO visitors_counter(VisitorIP,TimeStamp) VALUES('$visitor_ip',NOW())")
		or die("Can't CREATE visitor count!...");
		// ------------------------------------------------------------
	}
	

	$time_interval = LAST_X_MINUTES;

	$get_count = mysqli_query($conn, "SELECT COUNT(CounterId) AS Count FROM visitors_counter WHERE TimeStamp > (NOW() - INTERVAL $time_interval MINUTE)")
	or die("Can't ACCESS visitor count!...");
	// ------------------------------------------------------------
	
	if(mysqli_num_rows($get_count) > 0)
	{
		$row = mysqli_fetch_array($get_count);
		$current_count = $row['Count'];
	}
	else
	{
		$current_count = 0;
	}
}
else
{
	$current_count = 'off';
}
?>