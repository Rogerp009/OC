<?php
// ------------------------------------------------------------
// CREATE VARIABLES TO HOLD CONSTANT VALUE FROM WEBCONFIG
// ------------------------------------------------------------
$from_address = NO_REPLY;

// ------------------------------------------------------------
// CREATE HTML E-MAIL
// ------------------------------------------------------------
$user_name = $txbUn;
$email = $txbEmail;
$password = $txbPw;

$to = $email;
$subject = 'Your New Account is Ready';
$message = '
<html>
<head>
	<title>Your New Account is Ready</title>
</head>
<body>
	<p>Hello '.$user_name.',</p>
	<p>Your new account has been successfully created and is active now.</p>
	<p>User Name: '.$user_name.'</p>
	<p>Password: '.$password.'</p>
</body> 
</html>
';

// ------------------------------------------------------------
// SET HEADERS FOR HTML MAIL
// ------------------------------------------------------------
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: <'.$txbEmail.'>' . "\r\n";
$headers .= 'From: Your New Account is Ready <'.$from_address.'>' . "\r\n";
//$headers .= 'Cc: anothermail@foo.org' . "\r\n";
//$headers .= 'Bcc: '.$from_address.'' . "\r\n";

// ------------------------------------------------------------
// SEND E-MAIL
// ------------------------------------------------------------
mail($to, $subject, $message, $headers);
?>