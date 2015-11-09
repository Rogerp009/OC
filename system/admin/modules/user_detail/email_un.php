<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$get_user_email = mysqli_query($conn, "SELECT UserName, Email FROM users WHERE UserId = $user_id LIMIT 1") 
or die($dataaccess_error);

if(mysqli_num_rows($get_user_email) == 1)
{
	$row = mysqli_fetch_array($get_user_email);
	$user_name = $row['UserName'];
	$email = $row['Email'];
	
	$to = $email;
	$subject = 'User Name Reset Confirmation';
	$message = '
	<html>
	<head>
		<title>User Name Reset Confirmation</title>
	</head>
	<body>
		<p>Hello '.$user_name.',</p>
		<p>Your account user name has been successfully reset.</p>
		<p>New User Name: '.$user_name.'</p>
	</body> 
	</html>
	';
	
	// ------------------------------------------------------------
	// SET HEADERS FOR HTML MAIL
	// ------------------------------------------------------------
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
	$headers .= 'From: User Name Reset Confirmation <'.$from_address.'>' . "\r\n";
	//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
	//$headers .= 'Bcc: '.$from_address.'' . "\r\n";
	
	// ------------------------------------------------------------
	// SEND E-MAIL
	// ------------------------------------------------------------
	mail($to, $subject, $message, $headers);
	
	$msg = $un_reset_success2;
}
else
{
	$msg = $send_email_error;
}
?>